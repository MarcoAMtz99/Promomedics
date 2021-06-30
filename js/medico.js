
//$(document).ready(function() {

$('#mnu-med').addClass('active');
$('#mnu-info').addClass('active');

$(":input").inputmask();

moment.locale('es');
$('.datepicker').daterangepicker({
  singleDatePicker: true,
  format: "DD/MM/YYYY",
  calender_style: "picker_4"
});

$med = $('#med-id').val();
//getInst($med);
getEsp($med);

/*$('#gral-esp').change(function() {
  $('#gral-subes').addClass('disabled');
  NProgress.start();
  $.post('/core/medicos', 
    {action: 'getSubespecialidad', esp: $('#gral-esp').val()}, 
    function(resp) {
      $('#gral-subes').empty();
      $.each(resp, function(index, item) {
        $('#gral-subes').append('<option value="'+item.nombre+'">'+item.nombre+'</option>');
      });
      $('#gral-subes').removeClass('disabled');
      NProgress.done();
  },'json');
});*/

$('#gral-nac').change(function(){
  if($(this).val() == 'Mexicana'){
    $('#gral-lnace').removeClass('hide');
    $('#gral-lnac').addClass('hide');
  }else{
    $('#gral-lnac').removeClass('hide');
    $('#gral-lnace').addClass('hide');
  }
})

$('form').submit(function(event) {
  event.preventDefault();
});

$('.btnNext').click(function() {
  $('html, body').animate({
      scrollTop: 0//$("#med-id").offset().top
  }, 500);
  next = $(this).data('next');
  $('#myTabs li:eq('+next+') a').tab('show');
});

$('#btnUpdGral').click(function() {
  $('.alert').remove();
  $('.tooltip-error').remove();
  data = { med: $('#med-id').val() }

  //$.each($("input[type=text] [id*=gral-]"), function(index, el) {
  $.each($("[id*=gral-]"), function(index, el) {
    id = $(el).attr('id');
    id = id.replace('gral-', '');

    data[id] = $.trim($(el).val());
  });

  btn = $(this);
  btn.addClass('disabled');
  NProgress.start();

  $.post('/core/medicos/saveGral', 
    {data: $.toJSON(data)}, 
    function(resp) {
      if(resp.success){
        //$('#gral-idesp').val(resp.idesp);
        al = $('<div class="alert alert-success alert-dismissible fade in">Se guardaron los datos correctamente</div>');
        $('#tbl-inst').after(al);
        setTimeout(function(){ al.remove(); }, 5000);
      }else{
        setError('btnUpdGral', 'Ha ocurrido un error al guardar')
      }
      btn.removeClass('disabled');
      NProgress.done();
  },'json');
});


/** PRECARGAS **/
  $.each($('.precarga'), function(index, elem) {
    tipo = $(this).data('pre');
    $(elem).autocomplete({
      serviceUrl: '/core/autocomplete', 
      type: 'POST', dataType: 'json', 
      params: {tipo: tipo }, 
      autoSelectFirst: true, 
      noCache: true
    });  
  });

  $('.ac-esp').autocomplete({
    serviceUrl: '/core/autocomplete', 
    type: 'POST', dataType: 'json', 
    params: {tipo: 'especialidad' }, 
    autoSelectFirst: true, 
    noCache: true, 
    onSelect: function(item){ espChange($(this)['context'], item.data); }, 
    onInvalidateSelection: function(){ espChange($(this)['context'], 0); }, 
    onSearchStart: function(){ espChange($(this)['context'], 0); }
  });

  $('.ac-subesp').autocomplete({
    serviceUrl: '/core/autocomplete', 
    type: 'POST', dataType: 'json', 
    params: {tipo: 'subespecialidad' }, 
    autoSelectFirst: true, 
    noCache: true, 
    onSelect: function(item){ $(this).next('input:hidden').val(item.data) }, 
    onInvalidateSelection: function(){ $(this).next('input:hidden').val(0) },
    //onSearchStart: function(){ $(this).next('input:hidden').val(0) }
  });

  function espChange(elem, esp){
    $(elem).next('input:hidden').val(esp);
    $(elem).parents('.form-group').next().find('.ac-subesp').val('');
    $(elem).parents('.form-group').next().find('.ac-subesp').autocomplete('setOptions', {params: {tipo: 'subespecialidad', esp: esp }});
    $(elem).parents('.form-group').next().find('input:hidden').val(0); 
  }



/** ESPECIALIDADES **/
  function getEsp(med){
    NProgress.start();
    $.post('/core/medicos/getEspecialidades', 
      {med: med}, 
      function(resp) {
        $.each(resp.items, function(index, item) {
          addEspeRow(item, resp.act);
        });
        $('#tbl-espe .nodata').remove();
        //NProgress.done();
        getInst(med);
    },'json');
  }

  function addEspeRow(item, act){
    nuevo = true;
    //tr = $('<tr></tr>');
    tr = $('<tr data-id="'+item.ID+'"></tr>');
    if($("#tbl-espe [data-id='"+item.ID+"']").length > 0){
      nuevo = false;
      tr = $("#tbl-espe [data-id='"+item.ID+"']");
      tr.empty();
    }
    
    tr.append('<td>'+item.especialidad+'</td>');
    tr.append('<td>'+item.subespecialidad+'</td>');
    tr.append('<td>'+item.num_cedula+'</td>');
    tr.append('<td>'+act+'</td>');

    if(nuevo) $('#tbl-espe tbody').append(tr);
  }

  $('#btnAddMesp').click(function() {
    $('#espe-esps').parents('form').removeClass('hide');
    $('#tbl-espe .info').removeClass('info');
    $('#espe-esps').parents('form').find('input').val('');
    $('#espe-esp').val(0);
    $('#espe-subes').val(0);
    $('#espe-esps').val('').focus();
  });

  $('#btnCancelMesp').click(function() {
    $('#espe-esps').parents('form').addClass('hide');
    $('#espe-esps').parents('form input').val('');
  });

  $('body').on('click', '.btnespe-edit', function(){
    $('#tbl-espe .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');

    id = tr.data('id');
    $.post('/core/medicos/getEspecialidad', 
      {id: id}, 
      function(data) {
        $('#espe-esp').val(data.id_especialidad);
        $('#espe-subess').val(data.subespecialidad);
        $('#espe-subes').val(data.id_subespecialidad);
        $('#espe-nced').val(data.num_cedula);
        $('#espe-cert').val(data.num_recer);
        $('#espe-fvenc').val(data.fecha_recer);
        $('#espe-esps').parents('form').removeClass('hide');
        $('#espe-subess').autocomplete('setOptions', {params: {tipo: 'subespecialidad', esp: data.id_especialidad }});
        $('#espe-esps').val(data.especialidad).focus();
    },'json');
  });

  //$('#espe-nom').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveI').trigger('click'); } });

  $('#btnSaveMesp').click(function() {
    $('.alert').remove();
    $('.tooltip-error').remove();
    ide = 0;
    if($('#tbl-espe .info').length > 0) ide = $('#tbl-espe .info').data('id');
    data = { med: $('#med-id').val(), id: ide }

    $.each($("[id*=espe-]"), function(index, el) {
      id = $(el).attr('id');
      id = id.replace('espe-', '');

      data[id] = $.trim($(el).val());
    });

    btn = $(this);
    btn.addClass('disabled');
    frm = btn.parents('form');

    act = 'addEspecialidad';
    if(parseInt(ide,10) > 0) act = 'editEspecialidad';
    NProgress.start();
    $.post('/core/medicos/'+act, 
      {id: ide, med: $('#med-id').val(), data: $.toJSON(data)}, 
      function(resp) {
        if(!resp.error){
          addEspeRow(resp.item, resp.act);
          frm.addClass('hide');
          $('#tbl-espe .info').removeClass('info');
          btn.removeClass('disabled');
        }else{
          setError('btnSaveMesp', resp.msg);
          btn.removeClass('disabled');
        }
        NProgress.done();
    },'json');
  });

  $('body').on('click', '.btnespe-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text() + ' '+tr.find('td:eq(1)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delEspecialidad',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** INSTITUCIONES **/
  $('#btnAddI').click(function() {
    $('#inst-nom').parents('form').removeClass('hide');
    $('#tbl-inst .info').removeClass('info');
    $('#inst-nom').val('').focus();
  });

  $('body').on('click', '.btne-edit', function(){
    $('#tbl-inst .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    nom = tr.find('td:eq(0)').text();

    $('#inst-nom').parents('form').removeClass('hide');
    $('#inst-nom').val(nom).focus();
  });

  $('#inst-nom').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveI').trigger('click'); } });

  $('#btnSaveI').click(function() {
    nom = $.trim($('#inst-nom').val());
    med = $('#med-id').val();

    id = 0;
    if($('#tbl-inst .info').length > 0) id = $('#tbl-inst .info').data('id');

    if(nom.length < 4){
      setError('inst-nom', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addInstitucion';
      if(parseInt(id,10) > 0) act = 'editInstitucion';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, nom: nom}, 
        function(resp) {
          if(!resp.error){
            addInstRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-inst .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveI', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btne-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delInstitucion',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** CONTACTOS **/
  $('#btnAddC').click(function() {
    frm = $('#cont-nom').parents('form');
    $('#tbl-cont .info').removeClass('info');
    $(frm).find('input').val('');
    $('#cont-nom').focus();

    $('.cont-info').addClass('hide');
    $('.cont-info table tbody').empty();
  });

  $('body').on('click', '.btnc-edit', function(){
    $('#tbl-cont .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    nom = tr.find('td:eq(0) span:eq(0)').text();
    pat = tr.find('td:eq(0) span:eq(1)').text();
    mat = tr.find('td:eq(0) span:eq(2)').text();
    area = tr.find('td:eq(1)').text();
    pues = tr.find('td:eq(2)').text();

    $('#cont-nom').val(nom).focus();
    $('#cont-pat').val(pat);
    $('#cont-mat').val(mat);
    $('#cont-area').val(area);
    $('#cont-pues').val(pues);

    
    //$('#cont-info').removeClass('hide');
    cont = tr.data('id');
    $('.cont-info').addClass('hide');
    $('.cont-info table tbody').empty();
    getCel(cont);

  });

  $('#btnSaveC').click(function() {
    data = {med: $('#med-id').val(), nom: $.trim($('#cont-nom').val()), pat: $.trim($('#cont-pat').val()), mat: $.trim($('#cont-mat').val()), area: $.trim($('#cont-area').val()), pues: $.trim($('#cont-pues').val())}

    id = 0;
    if($('#tbl-cont .info').length > 0) id = $('#tbl-cont .info').data('id');
    data.id = id;

    if(data.nom.length < 4){
      setError('cont-nom', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      //frm = btn.parents('form');

      act = 'addContacto';
      if(parseInt(id,10) > 0) act = 'editContacto';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {data: $.toJSON(data)}, 
        function(resp) {
          if(!resp.error){
            addContRow(resp.item, resp.act);
            //frm.addClass('hide');
            //$('#tbl-cont .info').removeClass('info');
            btn.removeClass('disabled');

            /*frm = $('#cont-nom').parents('form');
            $('#tbl-cont .info').removeClass('info');
            $(frm).find('input').val('');*/

            if(act == 'addContacto'){
              $('.cont-info').removeClass('hide');
              $('.cont-info table tbody').empty();
              $('#tbl-cont tbody tr:last').addClass('info');
            }
          }else{
            setError('btnSaveC', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnc-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delContacto',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** CELULARES **/
  $('#btnAddCel').click(function() {
    $('#cel-num').parents('form').removeClass('hide');
    $('#tbl-cel .info').removeClass('info');
    $('#cel-num').val('').focus();
  });

  $('body').on('click', '.btncel-edit', function(){
    $('#tbl-cel .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    num = tr.find('td:eq(0)').text();

    $('#cel-num').parents('form').removeClass('hide');
    $('#cel-num').val(num).focus();
  });

  $('#cel-num').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveCel').trigger('click'); } });

  $('#btnSaveCel').click(function() {
    num = $.trim($('#cel-num').val());
    //med = $('#med-id').val();
    med = $('#tbl-cont .info').data('id');

    id = 0;
    if($('#tbl-cel .info').length > 0) id = $('#tbl-cel .info').data('id');

    if(num.length < 4){
      setError('cel-num', 'Debe ingresar el número');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addCelular';
      if(parseInt(id,10) > 0) act = 'editCelular';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, num: num}, 
        function(resp) {
          if(!resp.error){
            addCelRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-cel .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveCel', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btncel-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    num = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delCelular',
        {num: num, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** TELEFONOS **/
  $('#btnAddTel').click(function() {
    $('#tel-num').parents('form').removeClass('hide');
    $('#tbl-tel .info').removeClass('info');
    $('#tel-ext').val('');
    $('#tel-num').val('').focus();
  });

  $('body').on('click', '.btnt-edit', function(){
    $('#tbl-tel .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    num = tr.find('td:eq(0)').text();
    ext = tr.find('td:eq(1)').text();

    $('#tel-num').parents('form').removeClass('hide');
    $('#tel-ext').val(ext);
    $('#tel-num').val(num).focus();
  });

  $('#tel-num').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveTel').trigger('click'); } });

  $('#btnSaveTel').click(function() {
    num = $.trim($('#tel-num').val());
    ext = $.trim($('#tel-ext').val());
    //med = $('#med-id').val();
    med = $('#tbl-cont .info').data('id');

    id = 0;
    if($('#tbl-tel .info').length > 0) id = $('#tbl-tel .info').data('id');

    if(num.length < 4){
      setError('tel-num', 'Debe ingresar el número');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addTelefono';
      if(parseInt(id,10) > 0) act = 'editTelefono';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, num: num, ext: ext}, 
        function(resp) {
          if(!resp.error){
            addTelRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-tel .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveTel', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnt-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    num = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delTelefono',
        {num: num, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** CORREOS **/
  $('#btnAddM').click(function() {
    $('#mail-mail').parents('form').removeClass('hide');
    $('#tbl-mail .info').removeClass('info');
    $('#mail-mail').val('').focus();
  });

  $('body').on('click', '.btnm-edit', function(){
    $('#tbl-mail .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    mail = tr.find('td:eq(0)').text();

    $('#mail-mail').parents('form').removeClass('hide');
    $('#mail-mail').val(mail).focus();
  });

  $('#mail-mail').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveM').trigger('click'); } });

  $('#btnSaveM').click(function() {
    mail = $.trim($('#mail-mail').val());
    //med = $('#med-id').val();
    med = $('#tbl-cont .info').data('id');

    id = 0;
    if($('#tbl-mail .info').length > 0) id = $('#tbl-mail .info').data('id');

    if(mail.length < 4){
      setError('mail-mail', 'Debe ingresar el email');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addCorreo';
      if(parseInt(id,10) > 0) act = 'editCorreo';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, mail: mail}, 
        function(resp) {
          if(!resp.error){
            addMailRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-mail .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveCel', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnm-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    mail = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delCorreo',
        {mail: mail, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** PAGINAS **/
  $('#btnAddPag').click(function() {
    $('#pag-nom').parents('form').removeClass('hide');
    $('#tbl-pag .info').removeClass('info');
    $('#pag-dir').val('');
    $('#pag-nom').val('').focus();
  });

  $('body').on('click', '.btnp-edit', function(){
    $('#tbl-pag .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    nom = tr.find('td:eq(0)').text();
    dir = tr.find('td:eq(1)').text();

    $('#pag-nom').parents('form').removeClass('hide');
    $('#pag-dir').val(dir);
    $('#pag-nom').val(nom).focus();
  });

  $('#pag-dir').keydown(function (key) { if (key.keyCode == '13') { $('#btnSavePag').trigger('click'); } });

  $('#btnSavePag').click(function() {
    nom = $.trim($('#pag-nom').val());
    dir = $.trim($('#pag-dir').val());
    //med = $('#med-id').val();
    med = $('#tbl-cont .info').data('id');

    id = 0;
    if($('#tbl-pag .info').length > 0) id = $('#tbl-pag .info').data('id');

    if(nom.length < 4){
      setError('pag-nom', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addPagina';
      if(parseInt(id,10) > 0) act = 'editPagina';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, nom: nom, dir: dir}, 
        function(resp) {
          if(!resp.error){
            addPagRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-pag .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSavePag', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnp-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delPagina',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** IDIOMAS **/
  $("#idi-esc").inputmask('integer',{min:0, max:100});
  $("#idi-hab").inputmask('integer',{min:0, max:100});
  $('#idi-idi').autocomplete({lookup: ['Inglés', 'Español', 'Alemán', 'Francés']});
  $('#btnAddIdi').click(function() {
    $('#idi-idi').parents('form').removeClass('hide');
    $('#tbl-idi .info').removeClass('info');
    $('#idi-idi').val('').focus();
    $('#idi-esc').val('');
    $('#idi-hab').val('');
  });

  $('body').on('click', '.btni-edit', function(){
    $('#tbl-idi .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    idi = tr.find('td:eq(0)').text();
    hab = tr.find('td:eq(1)').text();
    esc = tr.find('td:eq(1)').text();

    $('#idi-idi').parents('form').removeClass('hide');
    $('#idi-idi').val(idi);
    $('#idi-hab').val(hab).focus();
    $('#idi-esc').val(esc);
  });

  $('#idi-esc').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveIdi').trigger('click'); } });

  $('#btnSaveIdi').click(function() {
    idi = $.trim($('#idi-idi').val());
    hab = $.trim($('#idi-hab').val());
    esc = $.trim($('#idi-esc').val());
    med = $('#med-id').val();

    id = 0;
    if($('#tbl-idi .info').length > 0) id = $('#tbl-idi .info').data('id');

    if(hab.length == ''){
      setError('idi-hab', 'Debe ingresar el porcentaje');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addIdioma';
      if(parseInt(id,10) > 0) act = 'editIdioma';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, idi: idi, hab: hab, esc: esc}, 
        function(resp) {
          if(!resp.error){
            addIdiRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-idi .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveIdi', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btni-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    idi = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delIdioma',
        {idi: idi, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** EXPERIENCIA CLINICA **/
  $('#btnAddEC').click(function() {
    $('#expc-desc').parents('form').removeClass('hide');
    $('#tbl-expc .info').removeClass('info');
    $('#expc-desc').val('').focus();
  });

  $('body').on('click', '.btnec-edit', function(){
    $('#tbl-expc .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    desc = tr.find('td:eq(0)').text();

    $('#expc-desc').parents('form').removeClass('hide');
    $('#expc-desc').val(desc).focus();
  });

  $('#btnSaveEC').click(function() {
    desc = $.trim($('#expc-desc').val());
    med = $('#med-id').val();

    id = 0;
    if($('#tbl-expc .info').length > 0) id = $('#tbl-expc .info').data('id');

    if(desc.length < 4){
      setError('expc-desc', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addExpCli';
      if(parseInt(id,10) > 0) act = 'editExpCli';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, desc: desc}, 
        function(resp) {
          if(!resp.error){
            addECRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-expc .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveEC', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnec-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delExpCli',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** EXPERIENCIA QUIRURGICA **/
  $('#btnAddEQ').click(function() {
    $('#expq-desc').parents('form').removeClass('hide');
    $('#tbl-expq .info').removeClass('info');
    $('#expq-desc').val('').focus();
  });

  $('body').on('click', '.btneq-edit', function(){
    $('#tbl-expq .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    desc = tr.find('td:eq(0)').text();

    $('#expq-desc').parents('form').removeClass('hide');
    $('#expq-desc').val(desc).focus();
  });

  $('#btnSaveEQ').click(function() {
    desc = $.trim($('#expq-desc').val());
    med = $('#med-id').val();

    id = 0;
    if($('#tbl-expq .info').length > 0) id = $('#tbl-expq .info').data('id');

    if(desc.length < 4){
      setError('expq-desc', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addExpQui';
      if(parseInt(id,10) > 0) act = 'editExpQui';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, desc: desc}, 
        function(resp) {
          if(!resp.error){
            addEQRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-expq .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveEQ', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btneq-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delExpQui',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** ESTUDIOS Y TRATAMIENTOS **/
  $('#btnAddET').click(function() {
    $('#expt-desc').parents('form').removeClass('hide');
    $('#tbl-expt .info').removeClass('info');
    $('#expt-desc').val('').focus();
  });

  $('body').on('click', '.btnet-edit', function(){
    $('#tbl-expt .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    desc = tr.find('td:eq(0)').text();

    $('#expt-desc').parents('form').removeClass('hide');
    $('#expt-desc').val(desc).focus();
  });

  $('#btnSaveET').click(function() {
    desc = $.trim($('#expt-desc').val());
    med = $('#med-id').val();

    id = 0;
    if($('#tbl-expt .info').length > 0) id = $('#tbl-expt .info').data('id');

    if(desc.length < 4){
      setError('expt-desc', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addEstTrat';
      if(parseInt(id,10) > 0) act = 'editEstTrat';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, desc: desc}, 
        function(resp) {
          if(!resp.error){
            addETRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-expt .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveEQ', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnet-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delEstTrat',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });



/** CURRICULUM **/
  $("[id*=-anio]").inputmask('integer',{min:1950, max:2017});
  $('.btnAddCurr').click(function() {
    tipo = $(this).data('tipo');

    $('#'+tipo+'-desc').parents('form').removeClass('hide');
    $('#tbl-'+tipo+' .info').removeClass('info');
    $('#'+tipo+'-anio').val('');
    $('#'+tipo+'-desc').val('').focus();
  });

  $('body').on('click', '.btncurr-edit', function(){
    tipo = $(this).parents('tr').data('tipo');

    $('#tbl-'+tipo+' .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    desc = tr.find('td:eq(0)').text();
    anio = tr.find('td:eq(1)').text();

    $('#'+tipo+'-desc').parents('form').removeClass('hide');
    $('#'+tipo+'-desc').val(desc).focus();
    $('#'+tipo+'-anio').val(anio);
  });

  $('.btnSaveCurr').click(function() {
    tipo = $(this).data('tipo');
    desc = $.trim($('#'+tipo+'-desc').val());
    anio = $.trim($('#'+tipo+'-anio').val());
    med = $('#med-id').val();

    id = 0;
    if($('#tbl-'+tipo+' .info').length > 0) id = $('#tbl-'+tipo+' .info').data('id');
    //console.log($.inArray(tipo, arrCur))
    if(desc.length < 4){
      setError(''+tipo+'-desc', 'Debe ingresar la descripción');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addCurriculum';
      if(parseInt(id,10) > 0) act = 'editCurriculum';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, desc: desc, anio: anio, tipo: $.inArray(tipo, arrCur)}, 
        function(resp) {
          if(!resp.error){
            addCurRow(resp.item, resp.act, tipo);
            frm.addClass('hide');
            $('#tbl-'+tipo+' .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            //setError('btnSaveEQ', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btncurr-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    tipo = tr.data('tipo');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delCurriculum',
        {nom: nom, id: id, tipo: tipo},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** FACTURACION **/
  $('#fact-cp').change(function() {
    cp = $.trim($(this).val());
    $('#fact-col').empty().addClass('disabled');
    NProgress.start();
    $.post('/core/medicos/getCP', 
      {cp: cp}, 
      function(resp) {
        if(resp.success){
          $('#fact-mun').val(resp.muni);
          $('#fact-ciu').val(resp.ciudad);
          $('#fact-edo').val(resp.estado);
          $.each(resp.colonia, function(index, val) {
            $('#fact-col').append('<option value="'+val+'">'+val+'</option>');
          });
          $('#fact-col').removeClass('disabled');
        }else{
          setError('fact-cp','Verifique el Código Postal');
        }
        NProgress.done();
    },'json');
  });

  $('#fact-tipo').change(function() {
    if($(this).val() == '1'){
      $('#facturacion-tab .persmoral').addClass('hide');
    }else{
      $('#facturacion-tab .persmoral').removeClass('hide');
    }
  });
  $('#fact-tipo').trigger('change');

  $('#btnSaveFact').click(function() {
    $('.alert').remove();
    $('.tooltip-error').remove();
    data = { med: $('#med-id').val() }

    $.each($("[id*=fact-]"), function(index, el) {
      id = $(el).attr('id');
      id = id.replace('fact-', '');

      data[id] = $.trim($(el).val());
    });

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();

    $.post('/core/medicos/saveFact', 
      {data: $.toJSON(data)}, 
      function(resp) {
        if(resp.success){
          $('#fact-id').val(resp.id);
          al = $('<div class="alert alert-success alert-dismissible fade in">Se guardaron los datos correctamente</div>');
          $('#fact-id').after(al);
          setTimeout(function(){ al.remove(); }, 5000);
        }else{
          setError('btnSaveFact', 'Ha ocurrido un error al guardar')
        }
        btn.removeClass('disabled');
        NProgress.done();
    },'json');
  });


/** CONSULTORIOS **/
  $(".time").inputmask("h:s");

  $('.btnNextC').click(function() {
    $('html, body').animate({
        //scrollTop: 0//$("#med-id").offset().top
        scrollTop: $("#consTabs").offset().top
    }, 500);
    next = $(this).data('next');
    $('#consTabs li:eq('+next+') a').tab('show');
  });

  $('#cons-cp').change(function() {
    cp = $.trim($(this).val());
    $('#cons-col').empty().addClass('disabled');
    NProgress.start();
    $.post('/core/medicos/getCP', 
      {cp: cp}, 
      function(resp) {
        if(resp.success){
          $('#cons-mun').val(resp.muni);
          $('#cons-ciu').val(resp.ciudad);
          $('#cons-edo').val(resp.estado);
          $.each(resp.colonia, function(index, val) {
            $('#cons-col').append('<option value="'+val+'">'+val+'</option>');
          });
          $('#cons-col').removeClass('disabled');
        }else{
          setError('cons-cp','Verifique el Código Postal');
        }
        NProgress.done();
    },'json');
  });

  $('#btnAddCons').click(function() {
    $('#cons-info input').val('');
    $('#tbl-cons .info').removeClass('info');
    $('#cons-info').removeClass('hide');
    //$('#datos-cons').addClass('hide');
    $('#cons-nom').focus();
  });

  $('body').on('click', '.btncons-edit', function(){
    $('#consTabs li:last').tooltip('destroy');
    $('#tbl-cons .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    nom = tr.find('td:eq(0)').text();
    prim = tr.find('td:eq(1)').text();
    sub = tr.find('td:eq(2)').text();
    pref = tr.find('td:eq(3)').text();

    $('#cons-prim').val(prim);
    $('#cons-sub').val(sub);
    $('#cons-pref').val(pref);
    $('#cons-nom').val(nom).focus();

    $('#cons-info').removeClass('hide');
    $('#consTabs span').html(nom);
    $('#btnCopyAse').addClass('hide');

    cons = tr.data('id');

    //$('#datos-cons').addClass('hide');
    NProgress.start();
    $('#datos-cons table tbody').empty();
    $.post('/core/medicos/getConsDir', 
      {cons: cons}, 
      function(resp) {
        $('#cons-col').empty().addClass('disabled');
        $.each(resp.col, function(index, val) {
          $('#cons-col').append('<option value="'+val+'">'+val+'</option>');
        });
        $('#cons-col').removeClass('disabled');
        $('#cons-mun').val(resp.info.municipio);
        $('#cons-ciu').val(resp.info.ciudad);
        $('#cons-edo').val(resp.info.estado);
        $('#cons-col').val(resp.info.colonia);
        $('#cons-calle').val(resp.info.calle);
        $('#cons-ext').val(resp.info.exterior);
        $('#cons-int').val(resp.info.interior);
        $('#cons-cp').val(resp.info.codigo_postal);

        $('#promo-serv').autocomplete('setOptions', {params: {tipo: 'servicio_med', med: cons, tbl: 'medico' }});

        //$('#cmd-giro').val(resp.info.giro);
        //$('#cmd-slo').val(resp.info.slogan);
        
        $('#datos-cons').removeClass('hide');
        getConv(cons, true);

    },'json');
  });

  $('#btnCopyCons').click(function() {
    btn = $(this);
    cons = $('#tbl-cons .info').data('id');
    tipo = $('#copyc-tipo').val();

    btn.addClass('disabled');
    NProgress.start();
    $.post('/core/medicos/copyConsData', 
      {tipo: tipo, ori: $('#copyc-ori').val(), dest: $('#copyc-dest').val()}, 
      function(resp) {
        if(resp.success > 0){
          btn.removeClass('disabled');
          $('#copyc-tipo').val('');
          $('#copyc-ori').val('');
          $('#copyc-dest').val('');
          $('#form-copyCons').modal('hide');
          if(tipo == 'convenios') getConv(cons, false);
          else if(tipo == 'aseguradoras') getAse(cons, false);
        }else{
          setError('btnCopyCons','Ocurrió algo extraño. Vuelva a intentarlo más tarde.');
        }
        NProgress.done();
    },'json');
  });

  $('#btnSaveCons').click(function() {
    nom = $.trim($('#cons-nom').val());
    med = $('#med-id').val();

    id = 0;
    if($('#tbl-cons .info').length > 0) id = $('#tbl-cons .info').data('id');

    data = {}
    $.each($("[id*=cons-]"), function(index, el) {
      ide = $(el).attr('id');
      ide = ide.replace('cons-', '');

      data[ide] = $.trim($(el).val());
    });

    if(nom.length < 4){
      setError('cons-nom', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addConsultorio';
      if(parseInt(id,10) > 0) act = 'editConsultorio';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, med: med, data: $.toJSON(data)}, 
        function(resp) {
          if(!resp.error){
            addConsRow(resp.item, resp.act);
            $("#tbl-cons [data-id='"+resp.item.ID+"']").addClass('info');

            btn.removeClass('disabled');
            $('#cons-info').removeClass('hide');
            $('#datos-cons').removeClass('hide');
            if(act == 'addConsultorio'){
              $('#datos-cons table tbody').empty();
              $("#tbl-cons [data-id='"+resp.item.ID+"']").find('.btncons-edit').trigger('click');
            }
          }else{
            setError('btnSaveCons', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btncons-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    tipo = tr.data('tipo');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delConsultorio',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** CONVENIOS **/
  $('#btnAddConv').click(function() {
    $('#conv-desc').parents('form').removeClass('hide');
    $('#tbl-conv .info').removeClass('info');
    $('#conv-costo').val('');
    $('#conv-desc').val('').focus();
  });

  $('body').on('click', '.btnconv-edit', function(){
    $('#tbl-conv .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    desc = tr.find('td:eq(0)').text();
    costo = tr.find('td:eq(1)').text();

    $('#conv-desc').parents('form').removeClass('hide');
    $('#conv-costo').val(costo);
    $('#conv-desc').val(desc).focus();
  });

  $('#conv-costo').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveConv').trigger('click'); } });

  $('#btnSaveConv').click(function() {
    desc = $.trim($('#conv-desc').val());
    costo = $.trim($('#conv-costo').val());
    cons = $('#tbl-cons .info').data('id');

    id = 0;
    if($('#tbl-conv .info').length > 0) id = $('#tbl-conv .info').data('id');

    if(desc.length < 4){
      setError('conv-desc', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addConvenio';
      if(parseInt(id,10) > 0) act = 'editConvenio';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, cons: cons, desc: desc, costo: costo}, 
        function(resp) {
          if(!resp.error){
            addConvRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-conv .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveConv', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnconv-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delConvenio',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });

/** ASEGURADORAS **/
  $('#btnAddAse').click(function() {
    $('#ase-desc').parents('form').removeClass('hide');
    $('#tbl-ase .info').removeClass('info');
    $('#ase-costo').val('');
    $('#ase-desc').val('').focus();
  });

  $('#btnCopyAse').click(function() {
    cons = $('#tbl-cons .info').data('id');
    med = $('#med-id').val();
    tipo = 'aseguradoras';

    $('#form-copyCons h4 span').html(tipo).css('textTransform', 'capitalize');
    $('#form-copyCons .modal-body span:eq(1)').html(tipo).css('textTransform', 'capitalize');
    $('#copyc-tipo').val(tipo);
    $('#copyc-dest').val(cons);
    NProgress.start();
    $.post('/core/medicos/getInfoDataCons', {med: med, tipo: tipo}, function(resp) {
      if(resp.id > 0){
        $('#form-copyCons .modal-body span:eq(0)').html(resp.cuantos);
        $('#form-copyCons .modal-body span:eq(2)').html(resp.nombre);
        $('#copyc-ori').val(resp.id);

        $('#form-copyCons').modal('show');
        NProgress.done();
      }
    },'json');
  });

  $('body').on('click', '.btnase-edit', function(){
    $('#tbl-ase .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    desc = tr.find('td:eq(0)').text();
    costo = tr.find('td:eq(1)').text();

    $('#ase-desc').parents('form').removeClass('hide');
    $('#ase-costo').val(costo);
    $('#ase-desc').val(desc).focus();
  });

  $('#ase-costo').keydown(function (key) { if (key.keyCode == '13') { $('#btnSaveAse').trigger('click'); } });

  $('#btnSaveAse').click(function() {
    desc = $.trim($('#ase-desc').val());
    costo = $.trim($('#ase-costo').val());
    cons = $('#tbl-cons .info').data('id');

    id = 0;
    if($('#tbl-ase .info').length > 0) id = $('#tbl-ase .info').data('id');

    if(desc.length < 4){
      setError('ase-desc', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addAseguradora';
      if(parseInt(id,10) > 0) act = 'editAseguradora';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, cons: cons, desc: desc, costo: costo}, 
        function(resp) {
          if(!resp.error){
            addAseRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-ase .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveAse', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnase-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delAseguradora',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });

/** HORARIOS **/
  $('#hora-all').on('ifChecked', function(event){
    $('.hora-dias').iCheck('check');
  });

  $('#hora-all').on('ifUnchecked', function(event){
    dias = '';
    $.each($('.hora-dias'), function(index, el) {
      if($(el).iCheck('update')[0].checked) dias += $(el).data('dia');
    });
    if(dias.length == 7) $('.hora-dias').iCheck('uncheck');
  });

  $('.hora-dias').on('ifUnchecked', function(event){
    $('#hora-all').iCheck('uncheck');
  });

  $('.hora-dias').on('ifChecked', function(event){
    dias = '';
    $.each($('.hora-dias'), function(index, el) {
      if($(el).iCheck('update')[0].checked) dias += $(el).data('dia');
    });
    if(dias.length == 7) $('#hora-all').iCheck('check');
  });

  $('#btnClearH').click(function() {
    $('.tooltip-error').remove();  
    $('.hora-dias').iCheck('uncheck');
    $('#hora-ini').val('');
    $('#hora-fin').val('');
  });

  $('#btnSaveH').click(function() {
    dias = '';
    $.each($('.hora-dias'), function(index, el) {
      if($(el).iCheck('update')[0].checked) dias += $(el).data('dia');
    });
    ini = $('#hora-ini').val();
    fin = $('#hora-fin').val();

    consu = $('#tbl-cons .info').data('id');
    $('.tooltip-error').remove();
    btn = $(this);
    btn.attr('disabled','disabled');
    if(dias.length == 0){
      setError('btnSaveH','Debe elegir al menos un día');
      btn.removeAttr('disabled');
    }else if(ini.length < 4){
      setError('hora-ini','Debe ingresar una hora de inicio válida');
      btn.removeAttr('disabled');
    }else if(fin.length < 4){
      setError('hora-fin','Debe ingresar una hora de fin válida');
      btn.removeAttr('disabled');
    }else if(fin == ini){
      setError('hora-fin','La hora de inicio y fin no puede ser igual');
      btn.removeAttr('disabled');
    }else if(fin < ini){
      setError('hora-fin','La hora de inicio no puede ser mayor a la de fin');
      btn.removeAttr('disabled');
    }else{
      $.post('/core/medicos/saveHorario', 
        {tipo: 1, consu: consu, dias: dias, ini: ini, fin: fin}, 
        function(resp) {
          if(resp.success){
            $.each(resp.items, function(index, item) {
              addHoraItem(item);
            });
            $('#tbl-hora .nodata').remove();
            $('#hora-fin').val('');
            $('#hora-ini').val('').focus();
          }else{
            setError('btnSaveH','Ocurrio algo extraño. Vuelva a intentarlo más tarde.');
          }
          $(btn).removeAttr('disabled');
      },'json');
    }
  });

  $('body').on('click', '.btnDelHora', function(){
    td = $(this).parent();
    id = $(this).parent().data('id');
    $.post('/core/medicos/delHorario', {id: id}, function(resp) {
      if(resp.success){
        $(td).html('');
        $(td).removeAttr('data-id');
      }
    },'json');
  });

  function getHorarios(consu){
    $('#tbl-hora tbody').empty();
    $('#tbl-hora tbody').append('<tr class="nodata"><td colspan="7">Cargando..</td></tr>');
    $.post('/core/medicos/getHorarios', 
      {cons: consu, tipo: 1}, 
      function(resp) {
            $.each(resp.items, function(index, item) {
              addHoraItem(item);
            });
            if(resp.items.length == 0) $('#tbl-hora .nodata td').html('No hay horarios registrados');
            else $('#tbl-hora .nodata').remove();
            getHorariosQ(consu);
            //getCub(consu);
    },'json');
  }

  function addHoraItem(item){
    dia = item.dia - 1;
    btnd = ' <button type="button" class="close btnDelHora" aria-hidden="true" title="Eliminar">&times;</button>';

    agregado = false;
    $.each($('#tbl-hora .dia-'+dia), function(index, el) {
      txt = $(el).text();
      if(txt.length == 0){
        $(el).html(item.hora+btnd);
        $(el).attr('data-id',item.id);
        agregado = true;
        return false;
      }
    });
    if(!agregado){
      tr = $('<tr></tr>');
      for (var i = 0; i < 7; i++) {
        td = $('<td class="n dia-'+i+'"></td>');
        if(i == dia){
          td.append(item.hora+btnd);
          td.attr('data-id',item.id);
        }
        tr.append(td);
      }
      $('#tbl-hora tbody').append(tr);
    }
  }

  $('#horaq-all').on('ifChecked', function(event){
    $('.horaq-dias').iCheck('check');
  });

  $('#horaq-all').on('ifUnchecked', function(event){
    dias = '';
    $.each($('.horaq-dias'), function(index, el) {
      if($(el).iCheck('update')[0].checked) dias += $(el).data('dia');
    });
    if(dias.length == 7) $('.horaq-dias').iCheck('uncheck');
  });

  $('.horaq-dias').on('ifUnchecked', function(event){
    $('#horaq-all').iCheck('uncheck');
  });

  $('.horaq-dias').on('ifChecked', function(event){
    dias = '';
    $.each($('.horaq-dias'), function(index, el) {
      if($(el).iCheck('update')[0].checked) dias += $(el).data('dia');
    });
    if(dias.length == 7) $('#horaq-all').iCheck('check');
  });

  $('#btnClearHQ').click(function() {
    $('.tooltip-error').remove();  
    $('.horaq-dias').iCheck('uncheck');
    $('#horaq-ini').val('');
    $('#horaq-fin').val('');
  });

  $('#btnSaveHQ').click(function() {
    dias = '';
    $.each($('.horaq-dias'), function(index, el) {
      if($(el).iCheck('update')[0].checked) dias += $(el).data('dia');
    });
    ini = $('#horaq-ini').val();
    fin = $('#horaq-fin').val();

    consu = $('#tbl-cons .info').data('id');
    $('.tooltip-error').remove();
    btn = $(this);
    btn.attr('disabled','disabled');
    if(dias.length == 0){
      setError('btnSaveHQ','Debe elegir al menos un día');
      btn.removeAttr('disabled');
    }else if(ini.length < 4){
      setError('horaq-ini','Debe ingresar una hora de inicio válida');
      btn.removeAttr('disabled');
    }else if(fin.length < 4){
      setError('horaq-fin','Debe ingresar una hora de fin válida');
      btn.removeAttr('disabled');
    }else if(fin == ini){
      setError('horaq-fin','La hora de inicio y fin no puede ser igual');
      btn.removeAttr('disabled');
    }else if(fin < ini){
      setError('horaq-fin','La hora de inicio no puede ser mayor a la de fin');
      btn.removeAttr('disabled');
    }else{
      $.post('/core/medicos/saveHorario', 
        {tipo: 2, consu: consu, dias: dias, ini: ini, fin: fin}, 
        function(resp) {
          if(resp.success){
            $.each(resp.items, function(index, item) {
              addHoraQItem(item);
            });
            $('#tbl-horaq .nodata').remove();
            $('#horaq-fin').val('');
            $('#horaq-ini').val('').focus();
          }else{
            setError('btnSaveHQ','Ocurrio algo extraño. Vuelva a intentarlo más tarde.');
          }
          $(btn).removeAttr('disabled');
      },'json');
    }
  });

  function getHorariosQ(consu){
    $('#tbl-horaq tbody').empty();
    $('#tbl-horaq tbody').append('<tr class="nodata"><td colspan="7">Cargando..</td></tr>');
    $.post('/core/medicos/getHorarios', 
      {cons: consu, tipo: 2}, 
      function(resp) {
            $.each(resp.items, function(index, item) {
              addHoraQItem(item);
            });
            if(resp.items.length == 0) $('#tbl-horaq .nodata td').html('No hay horarios registrados');
            else $('#tbl-horaq .nodata').remove();
            getServ(consu);
            //getCub(consu);
    },'json');
  }

  function addHoraQItem(item){
    dia = item.dia - 1;
    btnd = ' <button type="button" class="close btnDelHora" aria-hidden="true" title="Eliminar">&times;</button>';

    agregado = false;
    $.each($('#tbl-horaq .dia-'+dia), function(index, el) {
      txt = $(el).text();
      if(txt.length == 0){
        $(el).html(item.hora+btnd);
        $(el).attr('data-id',item.id);
        agregado = true;
        return false;
      }
    });
    if(!agregado){
      tr = $('<tr></tr>');
      for (var i = 0; i < 7; i++) {
        td = $('<td class="n dia-'+i+'"></td>');
        if(i == dia){
          td.append(item.hora+btnd);
          td.attr('data-id',item.id);
        }
        tr.append(td);
      }
      $('#tbl-horaq tbody').append(tr);
    }
  }

/** CUBICULOS **/
  $('#btnAddCub').click(function() {
    //$('#cub-nom').parents('form').removeClass('hide');
    $('#tbl-cub .info').removeClass('info');
    $('#cub-med').val('');
    $('#cub-desc').val('');
    $('#cub-nom').val('').focus();
  });

  $('body').on('click', '.btncub-edit', function(){
    $('#tbl-cub .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    nom = tr.find('td:eq(0)').text();
    med = tr.find('td:eq(1)').text();
    desc = tr.find('td:eq(2)').text();

    //$('#cub-nom').parents('form').removeClass('hide');
    $('#cub-med').val(med);
    $('#cub-desc').val(desc);
    $('#cub-nom').val(nom).focus();
  });

  $('#btnSaveCub').click(function() {
    nom = $.trim($('#cub-nom').val());
    med = $.trim($('#cub-med').val());
    desc = $.trim($('#cub-desc').val());
    cons = $('#tbl-cons .info').data('id');

    id = 0;
    if($('#tbl-cub .info').length > 0) id = $('#tbl-cub .info').data('id');

    if(nom.length == 0){
      setError('cub-nom', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addCubiculo';
      if(parseInt(id,10) > 0) act = 'editCubiculo';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, cons: cons, nom: nom, med: med, desc: desc}, 
        function(resp) {
          if(!resp.error){
            addCubRow(resp.item, resp.act);
            //frm.addClass('hide');
            frm.find('input').val('');
            $('#cub-desc').val('');
            $('#tbl-cub .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            setError('btnSaveCub', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btncub-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delCubiculo',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** MEDIOS DIGITALES **/
  $('#btnSaveCMD').click(function() {
    giro = $.trim($('#cmd-giro').val());
    slo = $.trim($('#cmd-slo').val());
    //cons = $('#tbl-cons .info').data('id');
    cons = $('#med-id').val();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post('/core/medicos/saveDigitales', 
      {cons: cons, giro: giro, slo: slo}, 
      function(resp) {
        if(!resp.error){
          al = $('<div class="alert alert-success alert-dismissible fade in">Se guardaron los datos correctamente</div>');
          btn.before(al);
          setTimeout(function(){ al.remove(); }, 5000);
        }else{
          setError('btnSaveHor', 'Ocurtrio algo extraño');
        }
        btn.removeClass('disabled');
        NProgress.done();
    },'json');
  });


  $('.btnAddDig').click(function() {
    tipo = $(this).data('tipo');

    $('#'+tipo+'-desc').parents('form').removeClass('hide');
    $('#tbl-'+tipo+' .info').removeClass('info');
    //$('#'+tipo+'-anio').val('');
    $('#'+tipo+'-desc').val('').focus();
  });

  $('body').on('click', '.btndig-edit', function(){
    tipo = $(this).parents('tr').data('tipo');

    $('#tbl-'+tipo+' .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');
    desc = tr.find('td:eq(0)').text();
    //anio = tr.find('td:eq(1)').text();

    $('#'+tipo+'-desc').parents('form').removeClass('hide');
    $('#'+tipo+'-desc').val(desc).focus();
    //$('#'+tipo+'-anio').val(anio);
  });

  $('#tab_cdig [id*=-desc]').keydown(function (key) { if (key.keyCode == '13') { $(this).parents('form').find('.btnSaveDig').trigger('click'); } });

  $('.btnSaveDig').click(function() {
    tipo = $(this).data('tipo');
    desc = $.trim($('#'+tipo+'-desc').val());
    //cons = $('#tbl-cons .info').data('id');
    cons = $('#med-id').val();

    id = 0;
    if($('#tbl-'+tipo+' .info').length > 0) id = $('#tbl-'+tipo+' .info').data('id');
    //console.log($.inArray(tipo, arrCur))
    if(desc.length < 4){
      setError(''+tipo+'-desc', 'Debe ingresar la descripción');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addDigital';
      if(parseInt(id,10) > 0) act = 'editDigital';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {id: id, cons: cons, desc: desc, tipo: $.inArray(tipo, arrDig)}, 
        function(resp) {
          if(!resp.error){
            addDigRow(resp.item, resp.act, tipo);
            frm.addClass('hide');
            $('#tbl-'+tipo+' .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            //setError('btnSaveEQ', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btndig-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    tipo = tr.data('tipo');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delDigital',
        {nom: nom, id: id, tipo: tipo},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** REDES SOCIALES **/
  $('#btnAddRedS').click(function() {
    frm = $('#red-nom').parents('form');
    $('#tbl-redsol .info').removeClass('info');
    frm.removeClass('hide');
    $(frm).find('input').val('');
    $('#red-nom').focus();
  });

  $('body').on('click', '.btnred-edit', function(){
    $('#tbl-redsol .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');

    id = tr.data('id');
    $('#red-nom').parents('form').removeClass('hide');
    NProgress.start();
    $.post('/core/medicos/getRed', {id: id}, function(resp) {
      $('#red-link').val(resp.link);
      $('#red-nom').val(resp.nombre).focus();
      NProgress.done();
    },'json');
  });

  $('#btnSaveRedS').click(function() {
    data = {med: $('#med-id').val(), 
            link: $.trim($('#red-link').val()), 
            nom: $.trim($('#red-nom').val())}
    var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;

    id = 0;
    if($('#tbl-redsol .info').length > 0) id = $('#tbl-redsol .info').data('id');
    data.id = id;

    if(data.nom.length < 4){
      setError('red-nom', 'Debe ingresar el nombre');
    }else if(data.link.length < 4){
      setError('red-link', 'Debe ingresar el link de la página o perfil');
    }else if(!pattern.test(data.link)){
      setError('red-link', 'Debe ingresar un link válido');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addRed';
      if(parseInt(id,10) > 0) act = 'editRed';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {data: $.toJSON(data)}, 
        function(resp) {
          if(!resp.error){
            addRedRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-redsol .info').removeClass('info');
            btn.removeClass('disabled');
            $(frm).find('input').val('');
          }else{
            setError('btnSaveRedS', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnred-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delRed',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** PROMOCIONES **/
  $('#promo-desde').daterangepicker({
      singleDatePicker: true,
      format: "DD/MM/YYYY",
      calender_style: "picker_4",
      minDate: moment()
    }, 
    function(start, end, label) {
      $('#promo-hasta').val('');
      $('#promo-hasta').daterangepicker({
        singleDatePicker: true,
        format: "DD/MM/YYYY",
        calender_style: "picker_4",
        minDate: start
      });
      $('#promo-hasta').focus();
  });

  $('#btnAddPromo').click(function() {
    frm = $('#promo-nom').parents('form');
    $('#tbl-promo .info').removeClass('info');
    frm.removeClass('hide');
    $(frm).find('input').val('');
    $('#promo-servid').val(0);
    $('#promo-descu').val(0);
    $('#promo-desc').removeAttr('readonly');
    $('#promo-costo').removeAttr('readonly');
    $('#promo-nom').focus();
  });

  $('#btnCancelPromo').click(function() {
    frm = $('#promo-nom').parents('form');
    $('#tbl-promo .info').removeClass('info');
    $(frm).find('input').val('');
    frm.addClass('hide');
  });

  //params: {tipo: 'servicio_med', med: $('#med-id').val(), tbl: 'medico'}, 
  $('#promo-serv').autocomplete({
    serviceUrl: '/core/autocomplete', 
    type: 'POST', dataType: 'json', 
    params: {tipo: 'servicio_med', med: $('#tbl-cons .info').data('id'), tbl: 'medico'}, 
    autoSelectFirst: true, 
    noCache: true, 
    onSelect: function(item){
      espChange($(this)['context'], item.data);
      NProgress.start();
      $.post('/core/medicos/getServicio', {id: item.data}, function(resp) {
        $('#promo-servid').val(resp.ID);
        $('#promo-desc').val(resp.descripcion);
        $('#promo-costo').val(resp.costo);
        $('#promo-desc').attr('readonly','readonly');
        $('#promo-costo').attr('readonly','readonly');
        calcCostoPromo();
        $('#promo-desde').focus();
        NProgress.done();
      },'json'); 
    }, 
    onInvalidateSelection: function(){ 
      $('#promo-servid').val(0);
      $('#promo-desc').val('').removeAttr('readonly');
      $('#promo-costo').val('').removeAttr('readonly');
      $('#promo-costod').val('');
    }, 
    onSearchStart: function(){ 
      $('#promo-servid').val(0); 
      $('#promo-desc').val('').removeAttr('readonly');
      $('#promo-costo').val('').removeAttr('readonly');
      $('#promo-costod').val('');
    }
  });

  $('body').on('keyup mouseup', '#promo-descu', function() {
    costo = parseFloat($('#promo-costo').val().replace(', ',''));
    calcCostoPromo(costo, $(this).val());
  });

  function calcCostoPromo(costo, descu){
    desc = (descu / 100) * costo;
    costod = costo - desc;
    $('#promo-costod').val(costod.toFixed(2));
  }

  $('body').on('click', '.btnpromo-edit', function(){
    $('#tbl-promo .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');

    id = tr.data('id');
    $('#promo-nom').parents('form').removeClass('hide');
    NProgress.start();
    $.post('/core/medicos/getPromo', {id: id}, function(resp) {
      $('#promo-serv').val(resp.servicio);
      $('#promo-cve').val(resp.clave);
      $('#promo-servid').val(resp.fk_servicio);
      $('#promo-desc').val(resp.descripcion);
      $('#promo-costo').val(resp.costo);
      $('#promo-desde').val(resp.desde);
      $('#promo-hasta').val(resp.hasta);
      $('#promo-descu').val(resp.descuento);
      $('#promo-costod').val(resp.costo_desc);
      $('#promo-cond').val(resp.condiciones);
      $('#promo-desc').attr('readonly','readonly');
      $('#promo-costo').attr('readonly','readonly');
      $('#promo-nom').val(resp.nombre).focus();
      NProgress.done();
    },'json');
  });

  $('#btnSavePromo').click(function() {
    //data = {med: $('#med-id').val(), 
    cons = $('#tbl-cons .info').data('id');
    data = {med: cons, 
            servid: $('#promo-servid').val() }

    $.each($("[id*=promo-]"), function(index, el) {
      id = $(el).attr('id');
      id = id.replace('promo-', '');
      data[id] = $.trim($(el).val());
    });

    id = 0;
    if($('#tbl-promo .info').length > 0) id = $('#tbl-promo .info').data('id');
    data.id = id;
    data.servid = $('#promo-servid').val();

    if(data.nom.length < 4){
      setError('promo-nom', 'Debe ingresar el nombre');
    }else if(data.cve.length < 4){
      setError('promo-cve', 'Debe ingresar la clave');
    }else if(data.serv.length < 4){
      setError('promo-serv', 'Debe ingresar un servicio');
    }else if(data.desde.length < 4){
      setError('promo-desde', 'Debe seleccionar la fecha de inicio');
    }else if(data.hasta.length < 4){
      setError('promo-hasta', 'Debe seleccionar la fecha de fin');
    }else if(data.descu == ''){
      setError('promo-descu', 'Debe ingresar el descuento');
    }else if(data.cond.length < 4){
      setError('promo-cond', 'Debe ingresar las condiciones');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addPromo';
      if(parseInt(id,10) > 0) act = 'editPromo';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {data: $.toJSON(data)}, 
        function(resp) {
          if(!resp.error){
            addPromoRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-promo .info').removeClass('info');
            btn.removeClass('disabled');
            $(frm).find('input').val('');
          }else{
            if(resp.elem == 'gral') setError('btnSavePromo', resp.msg);
            if(resp.elem == 'cve') setError('promo-cve', 'Ya existe una promoción con esta clave');
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  var cCalif = $('<select class="promo-calif"></select>');
  cCalif.append('<option value="0">Sin calificación</option>');
  cCalif.append('<option value="1">Recomendable</option>');
  cCalif.append('<option value="2">Satisfactoria</option>');
  cCalif.append('<option value="3">No satisfactoria</option>');

  $('body').on('change', '.promo-calif', function(e){ 
    tr = $(this).parents('tr');
    id = tr.data('id');

    prev = $(this).parent().data('prev');
    calif = parseInt($(this).val());
    cbo = $(this);

      cbo.prop('disabled', true);
      NProgress.start();
      $.post('/core/medicos/califPromo',
          {id: id, calif: calif}, 
          function(resp) {
              cbo.prop('disabled', false);
              if(resp.error){
                  cbo.val(prev);
              }else{
                  cbo.parent().data('prev',calif);
              }
              NProgress.done();
      },'json');
  });


  $('body').on('click', '.btnpromo-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delPromo',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });



/** STAFF MEDICOS **/
  $('.btnAddStaff').click(function() {
    tipo = $(this).data('tipo');
    frm = $('#'+tipo+'-nom').parents('form');
    $('#tbl-'+tipo+' .info').removeClass('info');
    frm.find('input').val('');
    frm.removeClass('hide');
    //$('#'+tipo+'-esp').trigger('change');
    $('#'+tipo+'-esp').val(0);
    $('#'+tipo+'-sub').val(0);
    $('#'+tipo+'-nom').focus();
  });

  $('.btnCancelStaff').click(function() {
    tipo = $(this).data('tipo');
    frm = $('#'+tipo+'-nom').parents('form');
    frm.find('input').val('');
    frm.addClass('hide');
  });

  $('body').on('click', '.btnstaff-edit', function(){
    tipo = $(this).parents('tr').data('tipo');
    id = $(this).parents('tr').data('id');

    $('#tbl-'+tipo+' .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');

    NProgress.start();
    $.post('/core/medicos/getMedStaff', {id: id, tipo: tipo}, function(resp) {
        $('#'+tipo+'-nom').val(resp.info.nombre);
        $('#'+tipo+'-ape').val(resp.info.apellidos);
        $('#'+tipo+'-ced').val(resp.info.cedula_medico);
        
        $('#'+tipo+'-esps').val(resp.info.espStr);
        $('#'+tipo+'-esp').val(resp.info.especialidad);
        $('#'+tipo+'-subs').val(resp.info.subespStr);
        $('#'+tipo+'-sub').val(resp.info.subespecialidad);
        $('#'+tipo+'-subs').autocomplete('setOptions', {params: {tipo: 'subespecialidad', esp: resp.info.especialidad }});

        $('#'+tipo+'-rol').val(resp.info.rol);
        $('#'+tipo+'-cede').val(resp.info.cedula_esp);
        $('#'+tipo+'-mail').val(resp.info.email);
        $('#'+tipo+'-tel').val(resp.info.telefono);
        $('#'+tipo+'-cel').val(resp.info.celular);
        $('#'+tipo+'-telo').val(resp.info.otro_telefono);
        $('#'+tipo+'-nom').focus();
        NProgress.done();
        $('#'+tipo+'-nom').parents('form').removeClass('hide');
    },'json');
  });

  $('#tab_cstaff [id*=-tel]').keydown(function (key) { if (key.keyCode == '13') { $(this).parents('form').find('.btnSaveStaff').trigger('click'); } });

  $('.btnSaveStaff').click(function() {
    tipo = $(this).data('tipo');
    cons = $('#tbl-cons .info').data('id');
    btn = $(this);

    id = 0;
    if($('#tbl-'+tipo+' .info').length > 0) id = $('#tbl-'+tipo+' .info').data('id');
    //console.log($.inArray(tipo, arrCur))
    data = {cons: cons, id: id, tipo: tipo};
    frm = btn.parents('form');
    $.each($("[id*="+tipo+"-]"), function(index, el) {
      ide = $(el).attr('id');
      ide = ide.replace(tipo+'-', '');

      data[ide] = $.trim($(el).val());
    });

    if(data.nom.length < 4){
      setError(''+tipo+'-nom', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');

      act = 'addStaff';
      if(parseInt(id,10) > 0) act = 'editStaff';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {data: $.toJSON(data)}, 
        function(resp) {
          if(!resp.error){
            addStaffRow(resp.item, resp.act, tipo);
            frm.find('input').val('');
            $('#tbl-'+tipo+' .info').removeClass('info');
            btn.removeClass('disabled');
          }else{
            //setError('btnSaveEQ', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnstaff-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    tipo = tr.data('tipo');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delStaff',
        {nom: nom, id: id, tipo: tipo},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** SERVICIOS **/
  $('#btnAddServ').click(function() {
    frm = $('#serv-nom').parents('form');
    $('#tbl-serv .info').removeClass('info');
    frm.removeClass('hide');
    $(frm).find('input').val('');
    //$('#serv-descu').val(0);
    $('#serv-nom').focus();
  });

  $('body').on('click', '.btnserv-edit', function(){
    $('#tbl-serv .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');

    id = tr.data('id');
    $('#serv-nom').parents('form').removeClass('hide');
    NProgress.start();
    $.post('/core/medicos/getServicio', {id: id}, function(resp) {
      /*optional stuff to do after success */
      $('#serv-desc').val(resp.descripcion);
      $('#serv-costo').val(resp.costo);
      //$('#serv-descu').val(resp.descuento);
      //$('#serv-motivo').val(resp.motivo);
      //$('#serv-costod').val(resp.costo_desc);
      $('#serv-nom').val(resp.nombre).focus();
      NProgress.done();
    },'json');
  });

  $('#btnSaveServ').click(function() {
    //data = {med: $('#med-id').val(), 
    cons = $('#tbl-cons .info').data('id');
    data = {med: cons, 
            nom: $.trim($('#serv-nom').val()), 
            desc: $.trim($('#serv-desc').val()), 
            costo: $.trim($('#serv-costo').val())/*, 
            descu: $.trim($('#serv-descu').val()), 
            motivo: $.trim($('#serv-motivo').val()), 
          costod: $.trim($('#serv-costod').val())*/}

    id = 0;
    if($('#tbl-serv .info').length > 0) id = $('#tbl-serv .info').data('id');
    data.id = id;

    if(data.nom.length < 4){
      setError('serv-nom', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addServicio';
      if(parseInt(id,10) > 0) act = 'editServicio';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {data: $.toJSON(data)}, 
        function(resp) {
          if(!resp.error){
            addServRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-serv .info').removeClass('info');
            btn.removeClass('disabled');
            $(frm).find('input').val('');
          }else{
            setError('btnSaveC', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnserv-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delServicio',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });

  /*$('#serv-costo').inputmask('decimal');
  $('#serv-costo').change(function() { calcCostod(); });
  $('#serv-descu').change(function() { calcCostod(); $('#serv-motivo').focus(); });
  function calcCostod(){
    costo = parseFloat($('#serv-costo').val());
    if(!$.isNumeric(costo)) costo = 0;

    desc = (parseInt($('#serv-descu').val()) / 100) * costo;

    costod = costo - desc;

    $('#serv-costod').val(costod.toFixed(2));
  }*/


/** LISTAS DESCUENTO **/
  $('#btnAddDescu').click(function() {
    frm = $('#descu-motivo').parents('form');
    $('#tbl-descu .info').removeClass('info');
    frm.removeClass('hide');
    $(frm).find('input').val('');
    $('#descu-descu').val(0);
    $('#descu-motivo').focus();
  });

  $('body').on('click', '.btndescu-edit', function(){
    $('#tbl-descu .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');

    id = tr.data('id');
    $('#descu-motivo').parents('form').removeClass('hide');
    NProgress.start();
    $.post('/core/medicos/getListaDesc', {id: id}, function(resp) {
      $('#descu-descu').val(resp.descuento);
      $('#descu-motivo').val(resp.motivo).focus();
      NProgress.done();
    },'json');
  });

  $('#btnSaveDescu').click(function() {
    //data = {med: $('#med-id').val(), 
    cons = $('#tbl-cons .info').data('id');
    data = {med: cons, 
            descu: $.trim($('#descu-descu').val()), 
            motivo: $.trim($('#descu-motivo').val())}

    id = 0;
    if($('#tbl-descu .info').length > 0) id = $('#tbl-descu .info').data('id');
    data.id = id;

    if(data.motivo.length < 4){
      setError('descu-motivo', 'Debe ingresar el motivo');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addListaDesc';
      if(parseInt(id,10) > 0) act = 'editListaDesc';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {data: $.toJSON(data)}, 
        function(resp) {
          if(!resp.error){
            addDescuRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-descu .info').removeClass('info');
            btn.removeClass('disabled');
            $(frm).find('input').val('');
          }else{
            setError('btnSaveDescu', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btndescu-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delListaDesc',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });

  $('body').on('click', '#tbl-descu tbody tr', function(event) {
    event.preventDefault();
    id = parseInt($(this).data('id'));

    if(id > 0){
      $('#tbl-descu .info').removeClass('info');
      $(this).addClass('info');
      NProgress.start();

      $.post('/core/medicos/getDescServ', 
        {lista: id}, 
        function(resp) {
          descDefault = resp.descuento; 
          $('#tbl-serv .serv-descu').val(descDefault);
          $.each($('#tbl-serv tbody tr'), function(index, elem) {
             costo = parseFloat($(elem).find('td:eq(2)').text().replace('$ ',''));
             calcCostoDesc(costo, descDefault, $(elem).find('td:eq(5)'), false);
          });
          $('#tbl-serv .serv-desc').removeClass('hide');

          $.each(resp.items, function(index, item) {
            tr = $('#tbl-serv [data-id="'+item.fk_servicio+'"]');
            if(tr == undefined) tr = $('#tbl-prod [data-id="'+item.fk_servicio+'"]');
            tr.find('.serv-descu').val(item.descuento);
            costo = parseFloat($(tr).find('td:eq(2)').text().replace('$ ',''));
            calcCostoDesc(costo, item.descuento, $(tr).find('td:eq(5)'), false);
          });


          $('#tbl-prod .serv-descu').val(descDefault);
          $.each($('#tbl-prod tbody tr'), function(index, elem) {
             costo = parseFloat($(elem).find('td:eq(2)').text().replace('$ ',''));
             calcCostoDesc(costo, descDefault, $(elem).find('td:eq(5)'), false);
          });
          $('#tbl-prod .serv-desc').removeClass('hide');


          NProgress.done();
      },'json');
    }
  });

  $('body').on('keyup mouseup', '#tbl-serv .serv-descu', function() {
    costo = parseFloat($(this).parents('tr').find('td:eq(2)').text().replace('$ ',''));
    calcCostoDesc(costo, $(this).val(), $(this).parent().next(), true);
  });

  $('body').on('keyup mouseup', '#tbl-prod .serv-descu', function() {
    costo = parseFloat($(this).parents('tr').find('td:eq(2)').text().replace('$ ',''));
    calcCostoDesc(costo, $(this).val(), $(this).parent().next(), true);
  });

  function calcCostoDesc(costo, descu, celda, guardar){
    desc = (descu / 100) * costo;
    costod = costo - desc;
    $(celda).text('$ '+costod.toFixed(2));

    if(guardar){
      lista = $('#tbl-descu .info').data('id');
      serv = $(celda).parent().data('id');
      NProgress.start();
      $.post('/core/medicos/saveDescServ', {serv: serv, lista: lista, descu: descu, costo: costod.toFixed(2)}, 
        function(resp) {
          NProgress.done();
      });
    }
  }


/** PRODUCTOS **/
  $('#btnAddProd').click(function() {
    frm = $('#prod-nom').parents('form');
    $('#tbl-prod .info').removeClass('info');
    frm.removeClass('hide');
    $(frm).find('input').val('');
    //$('#serv-descu').val(0);
    $('#prod-nom').focus();
  });

  $('body').on('click', '.btnprod-edit', function(){
    $('#tbl-prod .info').removeClass('info');
    tr = $(this).parents('tr');
    tr.addClass('info');

    id = tr.data('id');
    $('#prod-nom').parents('form').removeClass('hide');
    NProgress.start();
    $.post('/core/medicos/getProducto', {id: id}, function(resp) {
      /*optional stuff to do after success */
      $('#prod-desc').val(resp.descripcion);
      $('#prod-costo').val(resp.costo);
      //$('#serv-descu').val(resp.descuento);
      //$('#serv-motivo').val(resp.motivo);
      //$('#serv-costod').val(resp.costo_desc);
      $('#prod-nom').val(resp.nombre).focus();
      NProgress.done();
    },'json');
  });

  $('#btnSaveProd').click(function() {
    //data = {med: $('#med-id').val(), 
    cons = $('#tbl-cons .info').data('id');
    data = {med: cons, 
            nom: $.trim($('#prod-nom').val()), 
            desc: $.trim($('#prod-desc').val()), 
            costo: $.trim($('#prod-costo').val())/*, 
            descu: $.trim($('#serv-descu').val()), 
            motivo: $.trim($('#serv-motivo').val()), 
          costod: $.trim($('#serv-costod').val())*/}

    id = 0;
    if($('#tbl-prod .info').length > 0) id = $('#tbl-prod .info').data('id');
    data.id = id;

    if(data.nom.length < 4){
      setError('prod-nom', 'Debe ingresar el nombre');
    }else{
      btn = $(this);
      btn.addClass('disabled');
      frm = btn.parents('form');

      act = 'addProducto';
      if(parseInt(id,10) > 0) act = 'editProducto';
      NProgress.start();
      $.post('/core/medicos/'+act, 
        {data: $.toJSON(data)}, 
        function(resp) {
          if(!resp.error){
            addProdRow(resp.item, resp.act);
            frm.addClass('hide');
            $('#tbl-prod .info').removeClass('info');
            btn.removeClass('disabled');
            $(frm).find('input').val('');
          }else{
            setError('btnSaveProd', resp.msg);
            btn.removeClass('disabled');
          }
          NProgress.done();
      },'json');
    }
  });

  $('body').on('click', '.btnprod-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delProducto',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            tr.remove();
          }
          NProgress.done();
        },'json');
  });


/** ARCHIVOS **/
  $('#btnAddFile').click(function() {
    frm = $('#file-name').parents('form');
    $('#tbl-file .info').removeClass('info');
    frm.removeClass('hide');
    $('#file-desc').val('');
    $('#file-name').focus();
  });

  $('#file-busca').click(function() {
    $(this).parents('.form-group').removeClass('has-error');
    $('#file-file').trigger('click');
  });

  $('#file-file').change(function(event) {
    var numFiles = $(this).get(0).files ? $(this).get(0).files.length : 1;

    if(numFiles == 1){
      label = $(this).val().replace(/\\/g, '/').replace(/.*\//, ''), 
      ext = label.split('.').pop().toLowerCase();
      arrExt = ['jpg','png','pdf','ppt','doc','xls','docx','pptx','xlsx'];

      peso = this.files[0].size;
      if($.inArray(ext, arrExt) < 0){
        $(this).parents('.form-group').addClass('has-error');
        label = 'Sólo archivos jpg, png, pdf, ppt, doc, xls, docx, pptx, xlsx';
        $(this).replaceWith($(this).val('').clone(true));
      }else if(peso > 2097152){ // 2MB MAX //5242880){ // 5MB MAX
        $(this).parents('.form-group').addClass('has-error');
        label = 'Sólo archivos menores a 5MB';
        $(this).replaceWith($(this).val('').clone(true));
      }else{
        label = label.replace('.'+ext, '');
        $('#file-ext').val(ext);
        $('#file-peso').val(peso);
      }
    }else{
      $(this).parents('.form-group').addClass('has-error');
      label = 'Debes seleccionar solo un archivo';
        $(this).replaceWith($(this).val('').clone(true));
    }
    $('#file-name').val(label).focus();
  });

  $('#btnSaveFile').click(function() {
      name = $.trim($('#file-name').val());
      desc = $.trim($('#file-desc').val());

      $('.tooltip-error').remove();
      btn = $(this);
      frm = btn.parents('form');
      if(!$('#file-name').parents('.form-group').hasClass('has-error')){
        if(!$('#btnSaveFile').hasClass('disabled')){
          btn.addClass('disabled');
          if(name.length == 0){
            setError('file-name','Debes seleccionar el archivo');
            btn.removeClass('disabled');
          }else{
            NProgress.start();
            $('#fileFrm').ajaxSubmit({
              url: '/core/medicos', 
              type: 'post', 
              dataType: 'json', 
              clearForm: true, 
              resetFrom: true, 
              success: function(resp){
                if(!resp.error){
                  $('#tbl-file').DataTable().destroy();
                  addFileRow(resp.item, resp.act);
                  frm.addClass('hide');
                  $('#tbl-file .info').removeClass('info');
                  $(frm).find('input').val('');
                  doTable('#tbl-file', 6);
                }else{
                  setError('btnSaveFile', resp.msg);
                }
                btn.removeClass('disabled');
                NProgress.done();
              }
            });
          }
        }
      }
  });

  $('body').on('click', '.btnfile-del', function(){
    tr = $(this).parents('tr');
    id = tr.data('id');
    nom = tr.find('td:eq(0)').text();

    btn = $(this);
    btn.addClass('disabled');
    NProgress.start();
    $.post(
        '/core/medicos/delFile',
        {nom: nom, id: id},
        function(resp){
          if(!resp.error){
            $('#tbl-file').DataTable().destroy();
            tr.remove();
            doTable('#tbl-file', 6);
          }
          NProgress.done();
        },'json');
  });

  $('body').on('click', '.btnfile-dwn', function(){
    url = $(this).parent().data('url');

    window.open('/data/'+url);
  });
  
//});
//

/** GUARDADO AUTOMATICO **/
setInterval(function(){
  $('#btnUpdGral').trigger('click');
  $('#btnSaveCMD').trigger('click');
  $('#btnSaveFact').trigger('click');
  //if($('#tbl-cons .info').length > 0) $('#btnSaveCons').trigger('click');
},120000);

function getInst(med){
  //NProgress.start();
  $.post('/core/medicos/getInstituciones', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addInstRow(item, resp.act);
      });
      $('#tbl-inst .nodata').remove();
      //NProgress.done();
      getCons(med);
  },'json');
}

function addInstRow(item, act){
  nuevo = true;
  //tr = $('<tr></tr>');
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-inst [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-inst [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.descripcion+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-inst tbody').append(tr);
}

function getCons(med){
  $.post('/core/medicos/getConsultorios', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addConsRow(item, resp.act);
      });
      getCont(med);
  },'json');
}

function addConsRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-cons [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-cons [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.nombre+'</td>');
  tr.append('<td>'+item.consultaPrimera+'</td>');
  tr.append('<td>'+item.consultaSubsecuente+'</td>');
  tr.append('<td>'+item.consultaPreferente+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-cons tbody').append(tr);
}

function getCont(med){
  //NProgress.start();
  $.post('/core/medicos/getContactos', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addContRow(item, resp.act);
      });
      //NProgress.done();
      //getCel(med);
      getIdi(med);
  },'json');
}

function addContRow(item, act){
  nuevo = true;
  //tr = $('<tr></tr>');
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-cont [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-cont [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td><span>'+item.nombre+'</span> <span>'+item.paterno+'</span> <span>'+item.materno+'</span></td>');
  tr.append('<td>'+item.area+'</td>');
  tr.append('<td>'+item.puesto+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-cont tbody').append(tr);
}

function getCel(cont){
  NProgress.start();
  $.post('/core/medicos/getCelulares', 
    {med: cont}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addCelRow(item, resp.act);
      });
      //NProgress.done();
      $('.cont-info').removeClass('hide');
      getTel(cont);
  },'json');
}

function addCelRow(item, act){
  nuevo = true;
  //tr = $('<tr></tr>');
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-cel [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-cel [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.numero+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-cel tbody').append(tr);
}

function getTel(cont){
  //NProgress.start();
  $.post('/core/medicos/getTelefonos', 
    {med: cont}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addTelRow(item, resp.act);
      });
      //NProgress.done();
      getMail(cont);
  },'json');
}

function addTelRow(item, act){
  nuevo = true;
  //tr = $('<tr></tr>');
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-tel [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-tel [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.numero+'</td>');
  tr.append('<td>'+item.ext+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-tel tbody').append(tr);
}

function getMail(cont){
  //NProgress.start();
  $.post('/core/medicos/getCorreos', 
    {med: cont}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addMailRow(item, resp.act);
      });
      getPag(cont);
  },'json');
}

function addMailRow(item, act){
  nuevo = true;
  //tr = $('<tr></tr>');
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-mail [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-mail [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.correo+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-mail tbody').append(tr);
}

function getPag(cont){
  $.post('/core/medicos/getPaginas', 
    {med: cont}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addPagRow(item, resp.act);
      });
      //getIdi(med);
      NProgress.done();
  },'json');
}

function addPagRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-pag [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-pag [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.pagina+'</td>');
  tr.append('<td>'+item.direccion+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-pag tbody').append(tr);
}

function getIdi(med){
  $.post('/core/medicos/getIdiomas', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addIdiRow(item, resp.act);
      });
      getEC(med);
  },'json');
}

function addIdiRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-idi [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-idi [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.idioma+'</td>');
  tr.append('<td>'+item.hablado+'</td>');
  tr.append('<td>'+item.escrito+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-idi tbody').append(tr);
}

function getEC(med){
  $.post('/core/medicos/getExpCli', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addECRow(item, resp.act);
      });
      getEQ(med);
  },'json');
}

function addECRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-expc [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-expc [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.descripcion+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-expc tbody').append(tr);
}

function getEQ(med){
  $.post('/core/medicos/getExpQui', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addEQRow(item, resp.act);
      });
      getET(med);
  },'json');
}

function addEQRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-expq [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-expq [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.descripcion+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-expq tbody').append(tr);
}

function getET(med){
  $.post('/core/medicos/getEstTrat', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addETRow(item, resp.act);
      });
      getCur(med,0);
  },'json');
}

function addETRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-expt [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-expt [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.descripcion+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-expt tbody').append(tr);
}

arrCur = ['uni', 'cert', 'con', 'cur', 'esp'];
function getCur(med, tipo){
  $.post('/core/medicos/getCurriculum', 
    {med: med, tipo: tipo}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addCurRow(item, resp.act, arrCur[tipo]);
      });

      if(tipo < 4)
        getCur(med,tipo+1);
      else
        getDig(med,0);
        //getServ(med);
        //NProgress.done();
      //getCont(med);
  },'json');
}

function addCurRow(item, act, tbl){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'" data-tipo="'+tbl+'"></tr>');
  if($("#tbl-"+tbl+" [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-"+tbl+" [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.descripcion+'</td>');
  tr.append('<td>'+item.anio+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-'+tbl+' tbody').append(tr);
}

function getConv(cons, seguir){
  //NProgress.start();
  $('#tbl-conv tbody').empty();
  $.post('/core/medicos/getConvenios', 
    {cons: cons}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addConvRow(item, resp.act);
      });
      if(seguir) getAse(cons, true);
  },'json');
}

function addConvRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-conv [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-conv [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.empresa+'</td>');
  tr.append('<td>'+item.costo+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-conv tbody').append(tr);
}

function getAse(cons, seguir){
  $('#tbl-ase tbody').empty();
  $.post('/core/medicos/getAseguradoras', 
    {cons: cons}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addAseRow(item, resp.act);
      });
      if(seguir) getHorarios(cons);
      //NProgress.done();
  },'json');
}

function addAseRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-ase [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-ase [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.aseguradora+'</td>');
  tr.append('<td>'+item.costo+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-ase tbody').append(tr);
}

/*function getHorarios(consu){
  $('#tab_chor input').val('');
  $('#horac-id').val('0');
  $('#horaq-id').val('0');
  $.post('/core/medicos', 
    {action: 'getHorarios', cons: consu}, 
    function(resp) {
      cons = resp.cons;

      if(cons){
        $('#horac-id').val(cons.ID);
        $('#hora-tiem').val(cons.tiempo);
        $('#hora-cini').val(cons.comida);
        $('#hora-cfin').val(cons.comida2);

        $('#horac-lini').val(cons.lunes_inicio);
        $('#horac-lfin').val(cons.lunes_fin);
        $('#horac-mini').val(cons.martes_inicio);
        $('#horac-mfin').val(cons.martes_fin);
        $('#horac-miini').val(cons.miercoles_inicio);
        $('#horac-mifin').val(cons.miercoles_fin);
        $('#horac-jini').val(cons.jueves_inicio);
        $('#horac-jfin').val(cons.jueves_fin);
        $('#horac-vini').val(cons.viernes_inicio);
        $('#horac-vfin').val(cons.viernes_fin);
        $('#horac-sini').val(cons.sabado_inicio);
        $('#horac-sfin').val(cons.sabado_fin);
        $('#horac-dini').val(cons.domingo_inicio);
        $('#horac-dfin').val(cons.domingo_fin);
      }

      quir = resp.quir;
      if(quir){
        $('#horaq-id').val(quir.ID);
        $('#horaq-lini').val(quir.lunes_inicio);
        $('#horaq-lfin').val(quir.lunes_fin);
        $('#horaq-mini').val(quir.martes_inicio);
        $('#horaq-mfin').val(quir.martes_fin);
        $('#horacqmiini').val(quir.miercoles_inicio);
        $('#horacqmifin').val(quir.miercoles_fin);
        $('#horaq-jini').val(quir.jueves_inicio);
        $('#horaq-jfin').val(quir.jueves_fin);
        $('#horaq-vini').val(quir.viernes_inicio);
        $('#horaq-vfin').val(quir.viernes_fin);
        $('#horaq-sini').val(quir.sabado_inicio);
        $('#horaq-sfin').val(quir.sabado_fin);
        $('#horaq-dini').val(quir.domingo_inicio);
        $('#horaq-dfin').val(quir.domingo_fin);
      }

      getCub(consu);
      //NProgress.done();
  },'json');
}*/

function getCub(cons){
  $('#tbl-cub tbody').empty();
  $.post('/core/medicos/getCubiculos', 
    {cons: cons}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addCubRow(item, resp.act);
      });
      //getHorarios(cons);
      //NProgress.done();
      //getDig(cons,0);
      getStaff(cons, 0);
  },'json');
}

function addCubRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-cub [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-cub [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.nombre+'</td>');
  tr.append('<td>'+item.medico+'</td>');
  tr.append('<td>'+item.caracteristicas+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-cub tbody').append(tr);
}

arrDig = ['mds', 'mdp', 'pal', 'fra', 'ben'];
function getDig(cons, tipo){
  $.post('/core/medicos/getDigitales', 
    {cons: cons, tipo: tipo}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addDigRow(item, resp.act, arrDig[tipo]);
      });

      if(tipo < 4)
        getDig(cons,tipo+1);
      else
        getRedes(cons);
        //getFiles(cons);
        //getStaff(cons, 0);
        NProgress.done();
      //getCont(med);
  },'json');
}

function addDigRow(item, act, tbl){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'" data-tipo="'+tbl+'"></tr>');
  if($("#tbl-"+tbl+" [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-"+tbl+" [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.descripcion+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-'+tbl+' tbody').append(tr);
}

function getRedes(med){
  //NProgress.start();
  $.post('/core/medicos/getRedes', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addRedRow(item, resp.act);
      });
      getFiles(med);
      //getPromos(med);
      //if(resp.items.length > 0) $('#tbl-redsol tbody tr:eq(0)').trigger('click');
  },'json');
}

function addRedRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-redsol [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-redsol [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.nombre+'</td>');
  tr.append('<td>'+item.link+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-redsol tbody').append(tr);
}

function getPromos(med){
  //NProgress.start();
  $.post('/core/medicos/getPromos', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addPromoRow(item, resp.act);
      });
      getCub(med);
      //getFiles(med);
      //if(resp.items.length > 0) $('#tbl-redsol tbody tr:eq(0)').trigger('click');
  },'json');
}

function addPromoRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-promo [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-promo [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.nombre+'</td>');
  tr.append('<td>'+item.servicio+'</td>');
  tr.append('<td class="td-money">'+item.costo+'</td>');
  tr.append('<td class="td-money">'+item.costo_desc+'</td>');
  tr.append('<td>'+item.vigencia+'</td>');

  //tr.append('<td>'+item.calificacion+'</td>');
  tdc = $('<td data-prev="'+item.calificacion+'"></td>');
  tdc.append(cCalif.clone());
  tdc.find('select').val(item.calificacion);
  tr.append(tdc);

  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-promo tbody').append(tr);
}

arrStaff = ['medp', 'medq'];
function getStaff(cons, tipo){
  $.post('/core/medicos/getStaff', 
    {cons: cons, tipo: tipo}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addStaffRow(item, resp.act, arrStaff[tipo]);
      });

      if(tipo < 1){
        getStaff(cons,tipo+1);
      }else{
        NProgress.done();
      }
      //getCont(med);
  },'json');
}

function addStaffRow(item, act, tbl){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'" data-tipo="'+tbl+'"></tr>');
  if($("#tbl-"+tbl+" [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-"+tbl+" [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.nombre+'</td>');
  tr.append('<td>'+item.cedula_medico+'</td>');
  tr.append('<td>'+item.especialidad+'</td>');
  tr.append('<td>'+item.rol+'</td>');
  tr.append('<td>'+item.email+'</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-'+tbl+' tbody').append(tr);
}

function getServ(med){
  //NProgress.start();
  $.post('/core/medicos/getServicios', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addServRow(item, resp.act);
      });
      //getFiles(med);
      //getDig(med,0);
      //getIdi(med);
      getProd(med);
      $('#tbl-serv .serv-desc').addClass('hide');
  },'json');
}

function addServRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-serv [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-serv [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.nombre+'</td>');
  tr.append('<td><small>'+item.descripcion+'</small></td>');
  tr.append('<td class="td-money">$ '+item.costo+'</td>');
  tr.append('<td>'+act+'</td>');
  tr.append('<td class="serv-desc"><input type="number" min="5" max="100" class="serv-descu" class="form-control input-sm"> %</td>');
  tr.append('<td class="serv-desc td-money"></td>');

  if(nuevo) $('#tbl-serv tbody').append(tr);
}

function getProd(med){
  //NProgress.start();
  $.post('/core/medicos/getProductos', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addProdRow(item, resp.act);
      });
      //getFiles(med);
      //getDig(med,0);
      //getIdi(med);
      getDescu(med);
      $('#tbl-prod .prod-desc').addClass('hide');
  },'json');
}

function addProdRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-prod [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-prod [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.nombre+'</td>');
  tr.append('<td><small>'+item.descripcion+'</small></td>');
  tr.append('<td class="td-money">$ '+item.costo+'</td>');
  tr.append('<td>'+act+'</td>');
  tr.append('<td class="serv-desc"><input type="number" min="5" max="100" class="serv-descu" class="form-control input-sm"> %</td>');
  tr.append('<td class="serv-desc td-money"></td>');

  if(nuevo) $('#tbl-prod tbody').append(tr);
}

function getDescu(med){
  //NProgress.start();
  $.post('/core/medicos/getListasDesc', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addDescuRow(item, resp.act);
      });
      //getFiles(med);
      //getDig(med,0);
      //getIdi(med);
      getPromos(med);
      if(resp.items.length > 0) $('#tbl-descu tbody tr:eq(0)').trigger('click');
  },'json');
}

function addDescuRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-descu [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-descu [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.motivo+'</td>');
  tr.append('<td>'+item.descuento+' %</td>');
  tr.append('<td>'+act+'</td>');

  if(nuevo) $('#tbl-descu tbody').append(tr);
}

function getFiles(med){
  $.post('/core/medicos/getFiles', 
    {med: med}, 
    function(resp) {
      $.each(resp.items, function(index, item) {
        addFileRow(item, resp.act);
      });
      doTable('#tbl-file', 6);
      NProgress.done();
      $('.btncons-edit:eq(0)').trigger('click');
      $('.btnc-edit:eq(0)').trigger('click');
  },'json');
}

function addFileRow(item, act){
  nuevo = true;
  tr = $('<tr data-id="'+item.ID+'"></tr>');
  if($("#tbl-file [data-id='"+item.ID+"']").length > 0){
    nuevo = false;
    tr = $("#tbl-file [data-id='"+item.ID+"']");
    tr.empty();
  }
  
  tr.append('<td>'+item.nombre+'</td>');
  tr.append('<td>'+item.campana+'</td>');
  tr.append('<td>'+item.descripcion+'</td>');
  tr.append('<td>'+item.fecha+'</td>');
  tr.append('<td>'+item.extension+'</td>');
  tr.append('<td>'+item.peso+'</td>');
  tr.append('<td data-url="'+item.url+'">'+act+'</td>');

  if(nuevo) $('#tbl-file tbody').append(tr);
}

var $fubl = $('#btnFoto');
var logo_upldr = new qq.FineUploaderBasic({
    button: $fubl[0],
    multiple: false,
    autoUpload: true,
    request: {
        endpoint: '/core/medicos/changeFoto',
        params: {med: $('#med-id').val() }
    },
    validation: {
        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
        sizeLimit: 1048576 // 1MB = 1024 * 1024 bytes
    },
    callbacks: {
        onSubmit: function(id, fileName) {
          $('#messages').addClass('alert-info').html(fileName+' <strong>0 %</strong>');
          $('#btnFoto').addClass('disabled');
        },
        onProgress: function(id, fileName, loaded, total) {
          if (loaded <= total) {
              progress = Math.round(loaded / total * 100) + '% of ' + Math.round(total / 1024) + ' kB';
              $('#messages').find('strong').html(progress);
          }
        },
        onComplete: function(id, fileName, responseJSON) {
          if (responseJSON.success) {
            $('#messages').removeClass('alert-info').removeClass('alert-danger').addClass('alert-success').html('Se cambio correctamente la fotografia por '+fileName);
            $('#btnFoto').removeClass('disabled');
            $('#medico-foto').attr('src', responseJSON.url);
            $('#btnDelFoto').removeClass('hide');
            setTimeout(function(){ $('#messages').removeClass('alert-info').removeClass('alert-danger').removeClass('alert-success').html(''); },5000)
          }
        },
        onError: function(id, name, reason, xhr) {
          $('#messages').removeClass('alert-info').addClass('alert-danger').html(reason);
          $('#btnFoto').removeClass('disabled');
        }
    }
});

$('#btnDelFoto').click(function() {
  btn = $(this);
  $.post('/core/medicos/delFoto', 
    {med: $('#med-id').val()}, 
    function(resp) {
      $('#medico-foto').removeAttr('src');
      $('#medico-foto').attr('data-src', 'holder.js/100%x140/text:IMAGEN');
      Holder.run({images:"#medico-foto"});
      $(btn).tooltip('destroy');
      $(btn).addClass('hide');
  },'json');
});

Holder.invisible_error_fn = function(fn){
    return function(el){
        setTimeout(function(){
            fn.call(this, el)
        }, 10)
    }
}