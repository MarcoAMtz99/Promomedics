$(function(){
	$("[data-toggle='tooltip']").tooltip();

    //$('input, textarea').placeholder();

	$('body').on('click', '.tooltip-error', function(){
		$(this).remove();
    });

    $('.modal').modal({
        show: false,
        backdrop: 'static'
    });

    $('.modal').on('shown.bs.modal', function (e) {
        $(this).find('input:eq(0)').focus();
    });

	$('.numeric').keyup(function(e){
		if (/\D/g.test(this.value)){
			this.value = this.value.replace(/\D/g, '');
		}
	});

	$('.numeric-dot').keypress(function(e){
		var keynum = e.which;
		if ((keynum == 8) || (keynum == 46))
		return true;
		return (/\d/.test(String.fromCharCode(keynum)) /*|| /\-/.test(String.fromCharCode(keynum))*/);
		//return (/^-?[0-9]*[.][0-9]+$/.test(String.fromCharCode(keynum)));
		//str.match(/^-?[0-9]*[.][0-9]+$/)
	});

	$('#btnSavePass').click(function() {
		//if($('.body-content').length > 0){
			act = $.trim($('#pass-act').val());
			nva = $.trim($('#pass-new').val());
			rep = $.trim($('#pass-new2').val());

			$('#pass-act').tooltip('destroy');
			$('#pass-new').tooltip('destroy');
			$('#pass-new2').tooltip('destroy');
			btn = $(this);
			btn.addClass('disabled');
			var filter = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{8,15}/;

			if(act.length < 6){
				setError('pass-act', 'Este campo es obligatorio de al menos seis caracteres');
				btn.removeClass('disabled');
				return false;
			}/*else if(!filter.test(nva)){
				setError('pass-new', 'La nueva contraseña debe tener al menos 6 caracteres');
				btn.removeClass('disabled');
				return false;
			}*/else if(rep.length < 6){
				setError('pass-new2', 'Este campo es obligatorio de al menos seis caracteres');
				btn.removeClass('disabled');
				return false;
			}else if(nva != rep){
				setError('pass-new', 'Las contraseñas no coinciden');
				btn.removeClass('disabled');
				return false;
			}else{
				$.post(
					'core/action.php',
					{action: 'editPass', act: act, pass: nva},
					function(resp){
						if(!resp.error){
							$('#pass-act').val('');
							$('#pass-new').val('');
							$('#pass-new2').val('');
							$('#form-pass').find('.modal-body').append('<div class="alert alert-success">Se cambio la contraseña correctamente.</div>');
							btn.removeClass('disabled');
						}else{
							setError(resp.elem, resp.msg);
							btn.removeClass('disabled');
						}
					},'json');
			}
		//}
    });

    $('#form-pass').on('hidden.bs.modal', function () {
      $('#form-pass').find(".alert").alert('close');
    });

    $('.input-cp').change(function(){
      cp = $.trim($(this).val());
      gpo = $(this).parents('.form-group').next();
      col = gpo.find('input:eq(0)');
      gpo = $(gpo).next();
      mun = gpo.find('input:eq(0)');
      edo = gpo.find('input:eq(1)');
      if(cp != ''){
        fillDomi(col, mun, edo, cp);
      }
    });

    $('.currency').change(function() {
    	$(this).val(number_format($(this).val(),2));
    });

    function fillDomi(col, mun, edo, cp){
    	$.post('/core/action.php',
        	{action: 'getCPInfo', cp: cp},
        	function(resp){
        		$(col).val(resp.colonias[0].colonia);
        		$(mun).val(resp.municipio);
        		$(edo).val(resp.estado);
        	},'json');
    }
});

function setError(elem, msg){
	$('#'+elem).tooltip('destroy');
	msg = '<span class="fa fa-times fa-fw"></span> '+msg;
	$('#'+elem).tooltip({title: msg, trigger: 'manual', template: '<div class="tooltip tooltip-error"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>', html: true});
	$('#'+elem).tooltip('show');
	$('#'+elem).focus();
}

function setErrorElem(elem, msg){
    $(elem).tooltip('destroy');
    msg = '<span class="fa fa-times fa-fw"></span> '+msg;
    $(elem).tooltip({title: msg, trigger: 'manual', template: '<div class="tooltip tooltip-error"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>', html: true});
    $(elem).tooltip('show');
    //$(elem).focus();
}

function setErrorCbo(elem, msg){
	elem = $('#'+elem).parent();
	$(elem).tooltip('destroy');
	msg = '<span class="fa fa-times fa-fw"></span> '+msg;
	$(elem).tooltip({title: msg, trigger: 'manual', template: '<div class="tooltip tooltip-error"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>', html: true});
	$(elem).tooltip('show');
	$(elem).focus();
}

function setErrorCboM(elem, msg){
    elem = $('#'+elem).parent();
    console.log(elem, msg)
    $(elem).tooltip('destroy');
    msg = '<span class="fa fa-times fa-fw"></span> '+msg;
    $(elem).tooltip({title: msg, trigger: 'manual', template: '<div class="tooltip tooltip-error"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>', html: true});
    $(elem).tooltip('show');
    $(elem).focus();
}

function hideDatepicker(){
	$('.datepicker').datepicker('hide');
}

function doTable(elem, acttd){
    $(elem).DataTable({
        responsive: true, 
            order: [],
            "columnDefs": [
                { "orderable": false, "targets": acttd }
              ],
            fixedHeader: true, 
            'language': { 
                "url": "/js/Spanish.json"
            }
    });
}

function doDatePicker(elem){
	$(elem).datepicker({
            format: "dd/mm/yyyy",
            endDate: "0d",
            language: "es",
            autoclose: true,
            todayHighlight: true
        });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    var n = !isFinite(+number) ? 0 : +number, 
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}