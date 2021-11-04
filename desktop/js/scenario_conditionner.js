
/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */


/* Permet la réorganisation des commandes dans l'équipement */
$("#table_cmd").sortable({
  axis: "y",
  cursor: "move",
  items: ".cmd",
  placeholder: "ui-state-highlight",
  tolerance: "intersect",
  forcePlaceholderSize: true
});

/* Fonction permettant l'affichage des commandes dans l'équipement */
function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
     var _cmd = {configuration: {}};
   }
   if (!isset(_cmd.configuration)) {
     _cmd.configuration = {};
   }
  if(!isset(_cmd.configuration.cmdType)){
    _cmd.configuration.cmdType = 'default';
  }
   
   if(_cmd.configuration.cmdType=='default'){     
    var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
      tr += '<td style="width:60px;">';
      tr += '<span class="cmdAttr" data-l1key="id"></span>';
     tr += '<input class="cmdAttr" data-l1key="configuration" data-l2key="cmdType" value="'+init(_cmd.configuration.cmdType)+'" style="display:none;"/>';
      tr += '</td>';
     
      tr += '<td style="min-width:300px;width:350px;">';
      tr += '<div class="row">';
      tr += '<div class="col-xs-7">';
      tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" placeholder="{{Nom de la commande}}">';
      tr += '<select class="cmdAttr form-control input-sm" data-l1key="value" style="display : none;margin-top : 5px;" title="{{Commande information liée}}">';
      tr += '<option value="">{{Aucune}}</option>';
      tr += '</select>';
      tr += '</div>';
      tr += '<div class="col-xs-5">';
      tr += '<a class="cmdAction btn btn-default btn-sm" data-l1key="chooseIcon"><i class="fas fa-flag"></i> {{Icône}}</a>';
      tr += '<span class="cmdAttr" data-l1key="display" data-l2key="icon" style="margin-left : 10px;"></span>';
      tr += '</div>';
      tr += '</div>';
      tr += '</td>';
      tr += '<td>';
      tr += '<span class="type" type="' + init(_cmd.type) + '">' +  init(_cmd.type) + '</span>/';
      tr += '<span class="" subType="' + init(_cmd.subType) + '">' + init(_cmd.subType) + '</span>';
      //tr += '<span class="type" type="' + init(_cmd.type) + '">' + jeedom.cmd.availableType() + '</span>';
      //tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>';
      tr += '</td>';
      /*tr += '<td style="min-width:150px;width:350px;">';
      tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min.}}" title="{{Min.}}" style="width:30%;display:inline-block;"/> ';
      tr += '<input class="cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max.}}" title="{{Max.}}" style="width:30%;display:inline-block;"/> ';
      tr += '<input class="cmdAttr form-control input-sm" data-l1key="unite" placeholder="{{Unité}}" title="{{Unité}}" style="width:30%;display:inline-block;"/>';
      tr += '</td>';*/
      tr += '<td style="min-width:80px;width:350px;">';
      tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/>{{Afficher}}</label>';
      //tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="isHistorized" checked/>{{Historiser}}</label>';
      //tr += '<label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary"/>{{Inverser}}</label>';
      tr += '</td>';
      tr += '<td style="min-width:80px;width:200px;">';
      if (is_numeric(_cmd.id)) {
        tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fas fa-cogs"></i></a> ';
        tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fas fa-rss"></i> Tester</a>';
      }
      tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>';
      tr += '</tr>';
     
        $('#table_cmd tbody').append(tr);
   var tr = $('#table_cmd tbody tr').last();
     
  }else{
   var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
      tr += '<td style="width:10px;">';
      tr += '<span class="cmdAttr" data-l1key="id"></span>';
      tr += '<input class="cmdAttr" data-l1key="configuration" data-l2key="cmdType" value="'+init(_cmd.configuration.cmdType)+'" style="display:none;"/>';
      tr += '<input class="cmdAttr form-control input-sm type" data-l1key="type" value="info" style="display:none;"/>';
      tr += '<span class="subType" subType="string" value="string"  style="display:none;"></span>';
      tr += '</td>';
    //Nom
      tr += '<td style="min-width:15px;width:30px;">';
      tr += '<div class="row">';
      tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" placeholder="{{Nom de la commande}}">';
      tr += '</div>';
      tr += '</td>';
    //commande
      tr += '<td style="width:160px;">';
      tr += '<div class="input-group input-group-sm" style="padding-left: 15px;">';
      tr += '<input class="cmdAttr form-control" data-l1key="configuration" data-l2key="scenarCond"/>';
      tr += '<span class="input-group-btn">'
      tr += '<button type="button" class="btn btn-default cursor listCmdActionMessage tooltips cmdSendSel" title="{{Rechercher un scenario}}" data-input="sendCmd"><i class="fas fa-list-alt"></i></button>';
      tr += '</span>';
      tr += '</div>';
      tr += '</td>';
    
    // Action Entrée
    tr += '<td style="min-width:80px;width:100px;">';
    tr += '<select class="cmdAttr form-control " data-l1key="configuration" data-l2key="entry-act">';
   
    tr += '<option value="activate">{{Activer}}</option>';
    tr += '<option value="activate_launch">{{Activer et lancer}}</option>';
    tr += '<option value="deactivate">{{Désactiver}}</option>';
    tr += '<option value="none">{{Ne rien Faire}}</option>';
    tr += '</select>';
      // les tag du scenar
      tr += '<div class="tagConfDiv">'; 
      tr += '<span>tags : </span>';
      tr += '<input class="tags cmdAttr form-control" data-l1key="configuration" data-l2key="tag-entry"/>';
      tr += '</div>';
    tr += '</td>';
    // Action Sorie
    tr += '<td style="min-width:80px;width:100px;">';
    tr += '<select class="cmdAttr form-control" data-l1key="configuration" data-l2key="exit-act">';
    tr += '<option value="deactivate">{{Désactiver}}</option>';
    tr += '<option value="activate">{{Activer}}</option>';
    tr += '<option value="activate_launch">{{Activer et lancer}}</option>';
    tr += '<option value="none">{{Ne rien Faire}}</option>';
    tr += '</select>';
      // les tag du scenar
      tr += '<div class="tagConfDiv">'; 
      tr += '<span>tags : </span>';
      tr += '<input type="text" class="tags cmdAttr form-control" data-l1key="configuration" data-l2key="tag-exit"/>';
      tr += '</div>';
    tr += '</td>';
     //Actions
      tr += '<td style="min-width:5px;width:10px;">';
      tr += '<i class="fas fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>';
      tr += '</tr>';
    
    
    
    
    
  	$('#tableScenario_cmd tbody').append(tr);
   	var tr = $('#tableScenario_cmd tbody tr').last();
    
  }
  
  
  

  
  
   jeedom.eqLogic.builSelectCmd({
     id:  $('.eqLogicAttr[data-l1key=id]').value(),
     filter: {type: 'info'},
     error: function (error) {
       $('#div_alert').showAlert({message: error.message, level: 'danger'});
     },
     success: function (result) {
       tr.find('.cmdAttr[data-l1key=value]').append(result);
       tr.setValues(_cmd, '.cmdAttr');
       jeedom.cmd.changeType(tr, init(_cmd.subType));
     }
   });
  
  
   $(".cmdSendSel").on('click', function () {
        var el = $(this);

         jeedom.scenario.getSelectModal(null, function(result) {
         var calcul = el.closest('div').find('.cmdAttr[data-l1key=configuration][data-l2key=scenarCond]');
           calcul.val('');
         calcul.atCaret('insert', result.human);
       });
    });  


    $('.cmdAttr[data-l2key="entry-act"]').on('change click', function(){
      manageActionTag($(this));
    });
    $('.cmdAttr[data-l2key="exit-act"]').on('change click', function(){
      manageActionTag($(this));
    }); 
    $('.cmdAttr[data-l2key="entry-act"]').trigger('change');
    $('.cmdAttr[data-l2key="exit-act"]').trigger('change');
 }

/*              GESTION Ajout scenarion       */
$('.cmdAction[data-action=addSce]').on('click', function() {
   var _cmd = {configuration: {cmdType:'conditioner'}};
  addCmdToTable(_cmd)
  $('.cmd:last .cmdAttr[data-l1key=type]').trigger('change')
  modifyWithoutSave = true
});
/*              GESTION Action launch       */
//$('.cmdAttr[data-l2key=entry-act]').on('change', manageActionTag($(this)));
function manageActionTag(param){
  console.log(param.val());
  var tagEl = param.parent().find('.tagConfDiv');
  if(param.val()=='activate_launch'){
    tagEl.show();
  }else{
    tagEl.hide();
  }
};


/*              GESTION POUR LA SELECTION DES CONDITIONS       */
$('.bt_testExpressionSC').on('click', function(e){
  var expression = $('.eqLogicAttr[data-l2key=expression]').val();
  var modalSC=$('#md_modal').dialog({title: "Testeur"}).load('index.php?v=d&modal=expression.test').dialog({
    autoOpen: true,
    open: function () {
        setTimeout(function(){
          $("#in_testExpression").atCaret('insert',expression);
          $('#bt_executeExpressionOk').trigger('click');
      },100);  
    }
  });
})
var $divScenario = $('.tab-content')
var initSearch =0


$divScenario.on('click', '.bt_selectCmdExpressionSC', function(event) {
  var el = $(this)
  var expression = $(this).closest('.expression')
  var type = 'info'
  
  jeedom.cmd.getSelectModal({
    cmd: {
      type: type
    }
  }, function(result) {
   
      var message = getSelectCmdExpressionMessage(result.cmd.subType, result.human)
      bootbox.dialog({
        title: "{{Ajout d'une nouvelle condition}}",
        message: message,
        size: 'large',
        buttons: {
          "{{Ne rien mettre}}": {
            className: "btn-default",
            callback: function() {
              expression.find('.eqLogicAttr[data-l2key=expression]').atCaret('insert', result.human)
            }
          },
          success: {
            label: "{{Valider}}",
            className: "btn-primary",
            callback: function() {
              //setUndoStack()
              modifyWithoutSave = true
              var condition = result.human
              condition += ' ' + $('.conditionAttr[data-l1key=operator]').value()
              if (result.cmd.subType == 'string') {
                if ($('.conditionAttr[data-l1key=operator]').value() == 'matches') {
                  condition += ' "/' + $('.conditionAttr[data-l1key=operande]').value() + '/"'
                } else {
                  condition += " '" + $('.conditionAttr[data-l1key=operande]').value() + "'"
                }
              } else {
                condition += ' ' + $('.conditionAttr[data-l1key=operande]').value()
              }
              condition += ' ' + $('.conditionAttr[data-l1key=next]').value() + ' '
              expression.find('.eqLogicAttr[data-l2key=expression]').atCaret('insert', condition);
              expression.find('.eqLogicAttr[data-l2key=expression]').trigger('change');
              if ($('.conditionAttr[data-l1key=next]').value() != '') {
                el.click()
              }
            }
          },
        }
      })
    
  })
})
$('.eqLogicAttr[data-l2key=expression]').on('change keyup keypress', function(e){
  $("#cond_show").empty().append($(this).val());


})
// gestion de l'affichage de l'équipement
function printEqLogic(_mem) {

  $.ajax({
    type: "POST", 
    url: "plugins/scenario_conditionner/core/ajax/scenario_conditionner.ajax.php", 
    data: {
        action: "get-scenarList",
        eqlogicId:init(_mem.id)
    },
    dataType: 'json',
    error: function (request, status, error) {
        handleAjaxError(request, status, error);
    },
    success: function (data) { // si l'appel a bien fonctionné
        if (init(data.state) != 'ok') {
            $('#div_alert').showAlert({message: data.result, level: 'danger'});
            return;
        }
        //console.log(data.result);
        
        // onvide le wrapper
        var tbody=$("#table_scenar_show > tbody");
        tbody.empty();
        
        for (var i = 0, len = data.result.length; i < len; i++) {
          tbody.append("<tr>");
          tbody.append("<td class='table_resume'>"+data.result[i]["scenar"]+"</td>");
          tbody.append("<td class='table_resume'>"+data.result[i]["act_entry"]+"</td>");
          tbody.append("<td class='table_resume'>"+data.result[i]["act_exit"]+"</td>");
          tbody.append("</tr>");
         
        }

        
    }
  });
};