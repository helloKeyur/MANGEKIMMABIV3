
/*
**
** functions and methods are declare here
**
*/

const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success ml-2',
    cancelButton: 'btn btn-secondary ml-2'
  },
  buttonsStyling: false
});

// CK5 Editor
/*
ClassicEditor
.create( document.querySelector( '.editor' ), {
  toolbar: {
    items: [
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    'blockQuote',
    'insertTable',
    'undo',
    'redo',
    'heading'
    ]
  },
  language: 'en',
  table: {
    contentToolbar: [
    'tableColumn',
    'tableRow',
    'mergeTableCells'
    ]
  },
  licenseKey: '',
} )
.then( editor => {
  window.editor = editor;
} )
.catch( error => {
  console.error( 'Oops, something gone wrong!' );
  // console.error( 'Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:' );
  // console.warn( 'Build id: vxwvwj1tiu89-k7dnkq1rswkf' );
  console.error( error );
} );
*/

function ck5Editor(selector){
    ClassicEditor
    .create( selector, {
      toolbar: {
        items: [
        'bold',
        'italic',
        'link',
        'bulletedList',
        'numberedList',
        'blockQuote',
        'insertTable',
        'undo',
        'redo',
        'heading'
        ]
    },
    language: 'en',
    table: {
        contentToolbar: [
        'tableColumn',
        'tableRow',
        'mergeTableCells'
        ]
    },
    licenseKey: '',
    } )
    .then( editor => {
      window.editor = editor;
    } )
    .catch( error => {
      console.error( 'Oops, something gone wrong!' );
    // console.error( 'Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:' );
    // console.warn( 'Build id: vxwvwj1tiu89-k7dnkq1rswkf' );
    console.error( error );
    } );
}
//color picker
$('.color-picker').each( function() {
  $(this).minicolors({
    control: $(this).attr('data-control') || 'hue',
    defaultValue: $(this).attr('data-defaultValue') || '',
    format: $(this).attr('data-format') || 'hex',
    keywords: $(this).attr('data-keywords') || '',
    inline: $(this).attr('data-inline') === 'true',
    letterCase: $(this).attr('data-letterCase') || 'lowercase',
    opacity: $(this).attr('data-opacity'),
    position: $(this).attr('data-position') || 'bottom left',
    swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
    change: function(value, opacity) {
      if( !value ) return;
      if( opacity ) value += ', ' + opacity;
    },
    theme: 'bootstrap'
  });

}); 
// toast notifications 
resetToastPosition = function() {
  $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); // to remove previous position class
  $(".jq-toast-wrap").css({
    "top": "",
    "left": "",
    "bottom": "",
    "right": ""
  }); //to remove previous position style
}
showToast = function(heading,text,icon) {
  'use strict';
  resetToastPosition();
  $.toast({
    heading: heading,
    text: text,
      showHideTransition: 'plain', //slide,plain,fade
      icon: icon,
      loaderBg: '#21212160',
      position: 'bottom-right'
    })
};

// only accepts decimal numbers
$(document).on("keypress keyup blur",".allowDcNum",function (event) {
  //this.value = this.value.replace(/[^0-9\.]/g,'');
  $(this).val($(this).val().replace(/[^0-9\.]/g,''));
  if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});
/*
**  masterBtn id ex:#master
**  subBtn class ex:.sub_check
**  applyBtn id ex:#applyBtn
*/
function applyButtonDisableEnable(subCkBtn,applyBtn){
  if($(subCkBtn+':checked').length > 0){
    $(applyBtn).prop('disabled', false);;
  }
  else{
    $(applyBtn).prop('disabled',true);
  }
}
function checkbox(masterCkBtn,subCkBtn,applyBtn){
  $(document).on('click',masterCkBtn, function(e) {
    if($(this).is(':checked',true))  
    {
      $(subCkBtn).prop('checked', true);  
    } else {  
      $(subCkBtn).prop('checked',false);  
    }  
    applyButtonDisableEnable(subCkBtn,applyBtn);
  });
  $(document).on('change',subCkBtn,function(e){
    if ($(subCkBtn+':checked').length == $(subCkBtn).length) {
      $(masterCkBtn).prop('checked',true); 
    }else{
      $(masterCkBtn).prop('checked',false); 
    }
    applyButtonDisableEnable(subCkBtn,applyBtn);
  });
}

function checkBoxDataTable(masterCkBtn,s){
  
}
// createForm any form
function createForm(formId){
    var form_url = $(formId).attr('action');
    //form submitting
    $.ajax({
      url: form_url,
      type: 'POST',
      data : new FormData($(formId)[0]),
      dataType:'JSON',
      processData: false,
      contentType: false,
      xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
          $(".progress,.overlay").toggleClass('hidden');
          $("button[type='submit']").prop('disabled',true);
          $("small.err").text('');
          if (evt.lengthComputable) {
            var percentComplete = (evt.loaded / evt.total) * 100;
            $(".progress-bar").width(percentComplete + '%');
          }
        }, false);
        return xhr;
      },
      success:function(data){
        $("#errorBlock").addClass('hidden');
        showToast('Created',data.message,'success');
        setTimeout(()=>{
          window.location.href = data.redirect_to;
        },3000);
      },
      error: function (error) {
        showToast('Error',error.responseJSON.message,'error');
        $(window).scrollTop(0); 
        $("#showErrors li").replaceWith(' ');
        $("#errorBlock").removeClass('hidden');
        $("#showErrors").html('');
        $.each(error.responseJSON.errors, function (key, val) {
          $("#"+key+"-err").text(val[0]);
          $("#showErrors").append("<li>"+ val[0] +"</li>");
        });
      },
      complete : function(){
        $(".progress,.overlay").toggleClass('hidden');
        setTimeout(()=>{
          $("button[type='submit']").prop('disabled',false);
        },3000);
        $(".progress-bar").width(0 + '%');
      }
    });
}

//editForm any form edit method by just pass the data_url 
function editForm(formId){
  var form_url = $(formId).attr('action');
    //form submitting
    $.ajax({
      url: form_url,
      method: 'POST',
      data : new FormData($(formId)[0]),
      dataType:'JSON',
      processData: false,
      contentType: false,
      xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
          $(".progress,.overlay").toggleClass('hidden');
          $("button[type='submit']").prop('disabled',true);
          $("small.err").text('');
          if (evt.lengthComputable) {
            var percentComplete = (evt.loaded / evt.total) * 100;
            $(".progress-bar").width(percentComplete + '%');
          }
        }, false);
        return xhr;
      },
      success:function(data){
        showToast('Updated',data.message,'success');
        setTimeout(()=>{
          window.location.href = data.redirect_to;
        },3000);
      },
      error: function (error) {
        showToast('Error',error.responseJSON.message,'error');
        $(window).scrollTop(0); 
        $("#errorBlock").removeClass('hidden');
        $("#showErrors").html('');
        $.each(error.responseJSON.errors, function (key, val) {
          $("#_edit-"+key+"-err").text(val[0]);
          $("#showErrors").append("<li>"+ val[0] +"</li>");
        });
      },
      complete : function(){
        $(".progress,.overlay").toggleClass('hidden');
        setTimeout(()=>{
          $(document).find("button[type='submit']").prop('disabled',false);
        },3000);
        $(".progress-bar").width(0 + '%');
      }
    });
}

//get data of of ajax
function getData(getDataUrl){
  $.ajax({
      url: getDataUrl,
      type: 'POST',
      dataType: 'html',
      beforeSend:function(){
        $("div.loader").removeClass('hidden');
      },
      success:(data)=>{
        $("div.tabs_contant").html(data);
      },
      complete:(data)=>{
        $("div.loader").addClass('hidden');
      }
    });
}

function showDetails(showUrl,showInPlace = 'div.showModel',modelId = '#showModel'){
  $.ajax({
      url: showUrl,
      type: 'GET',
      dataType:'HTML',
      success:(result)=>{
        $(showInPlace).html(result);
        $(modelId).modal('show');
      }
    });
}
// move to trash single record by just pass the url of 
function moveToTrashOrDelete(trashRecordUrl){
  swalWithBootstrapButtons.fire({
      text: "You Want to move this record on trash?",
      showCancelButton: true,
      confirmButtonText: '<i class="ik trash-2 ik-trash-2"></i> Move to Trash!',
      cancelButtonText: 'Permanent Delete!',
      reverseButtons: true,
      showCloseButton : true,
      allowOutsideClick:false,
    }).then((result)=>{
      var action = (result.value) ? 'trash' : 'delete';
      if(result.value == true || result.dismiss == 'cancel'){
        $.ajax({
          url: trashRecordUrl,
          type: 'DELETE',
          data:{'action':action},
          dataType:'JSON',
          success:(result)=>{
            getData(result.getDataUrl);
            swalWithBootstrapButtons.fire({
              text: result.message,
              showConfirmButton:false,
              timer: 3000,
              timerProgressBar: true,
            }).then((result)=>{
              $("#pillsTab a[href='#live']").tab('show');
            })
          }
        });
      }
    });
}

// move to trash all record or delete all record by just pass url
function moveToTrashAllOrDelete(trashAllRecordUrl){
  var allVals = [];  
      
  $(".sub_chk:checked").each(function() {  
    allVals.push($(this).attr('data-id'));
  });  
  swalWithBootstrapButtons.fire({
    text: "You Want to move this record on trash?",
    showCancelButton: true,
    confirmButtonText: '<i class="ik trash-2 ik-trash-2"></i> Move to Trash!',
    cancelButtonText: 'Permanent Delete!',
    reverseButtons: true,
    showCloseButton : true,
    allowOutsideClick:false,
  }).then((result)=>{
    var action = (result.value) ? 'trash' : 'delete';
    if(result.value == true || result.dismiss == 'cancel'){
      $.ajax({
        url: trashAllRecordUrl,
        type: 'POST',
        data:{'action':action,'ids':allVals},
        dataType:'JSON',
        success:(result)=>{
          getData(result.getDataUrl);
          swalWithBootstrapButtons.fire({
            text: result.message,
            showConfirmButton:false,
            timer: 3000,
            timerProgressBar: true,
          }).then((result)=>{
            $("#pillsTab a[href='#live']").tab('show');
          })
        }
      });
    }
  });  
}

// move to Delete single record by just pass the url of 
function moveToDelete(trashRecordUrl){
  swalWithBootstrapButtons.fire({
      text: "You Want to Delete?",
      showCancelButton: true,
      confirmButtonText: '<i class="ik trash-2 ik-trash-2"></i> Permanent Delete!',
      cancelButtonText: 'Not Now!',
      reverseButtons: true,
      showCloseButton : true,
      allowOutsideClick:false,
    }).then((result)=>{
      var action = (result.value) ? 'trash' : 'delete';
      if(result.value == true){
        $.ajax({
          url: trashRecordUrl,
          type: 'DELETE',
          data:{'action':action},
          dataType:'JSON',
          success:(result)=>{
            // getData(result.getDataUrl);

            setTimeout(()=>{
              window.location.href = result.redirect_to;
            },3000);
            
            swalWithBootstrapButtons.fire({
              text: result.message,
              showConfirmButton:false,
              timer: 3000,
              timerProgressBar: true,
            }).then((result)=>{
              $("#pillsTab a[href='#live']").tab('show');
            })
          }
        });
      }
    });
}

// move to trash all record or delete all record by just pass url
function moveToDeleteAll(trashAllRecordUrl){
  var allVals = [];  
      
  $(".sub_chk:checked").each(function() {  
    allVals.push($(this).attr('data-id'));
  });  
  swalWithBootstrapButtons.fire({
    text: "You Want to move this record on trash?",
    showCancelButton: true,
    confirmButtonText: '<i class="ik trash-2 ik-trash-2"></i> Delete selected Records!',
    cancelButtonText: 'Not Now!',
    reverseButtons: true,
    showCloseButton : true,
    allowOutsideClick:false,
  }).then((result)=>{
    if(result.value == true){
      $.ajax({
        url: trashAllRecordUrl,
        type: 'POST',
        data:{'ids':allVals},
        dataType:'JSON',
        success:(result)=>{
          getData(result.getDataUrl);
          swalWithBootstrapButtons.fire({
            text: result.message,
            showConfirmButton:false,
            timer: 3000,
            timerProgressBar: true,
          }).then((result)=>{
            $("#pillsTab a[href='#live']").tab('show');
          })
        }
      });
    }
  });  
}

// restore
function restore(restoreUrl){
  swalWithBootstrapButtons.fire({
    text: "You Want to restore this record from trash?",
    showCancelButton: true,
    confirmButtonText: '<i class="ik rotate-ccw ik-rotate-ccw"></i> Restore!',
    cancelButtonText: 'Permanent Delete!',
    reverseButtons: true,
    showCloseButton : true,
    allowOutsideClick:false,
  }).then((result)=>{
    var action = (result.value) ? 'restore' : 'delete';
    if(result.value == true || result.dismiss == 'cancel'){
      $.ajax({
        url: restoreUrl,
        type: 'POST',
        data:{'action':action},
        dataType:'JSON',
        success:(result)=>{
          getData(result.getDataUrl);
          swalWithBootstrapButtons.fire({
            text: result.message,
            showConfirmButton:false,
            timer: 3000,
            timerProgressBar: true,
          }).then((result)=>{
            $("#pillsTab a[href='#live']").tab('show');
          })
        }
      });
    }
  });
}

//restore all
function restoreAll(restoreAllUrl){
  var allVals = [];  
  $(".rst_sub_chk:checked").each(function() {  
    allVals.push($(this).attr('data-id'));
  });  
  swalWithBootstrapButtons.fire({
    text: "You Want to restore this record from trash?",
    showCancelButton: true,
    confirmButtonText: '<i class="ik rotate-ccw ik-rotate-ccw"></i> Restore!',
    cancelButtonText: 'Permanent Delete!',
    reverseButtons: true,
    showCloseButton : true,
    allowOutsideClick:false,
  }).then((result)=>{
      var action = (result.value) ? 'restore' : 'delete';
      if(result.value == true || result.dismiss == 'cancel'){
        $.ajax({
          url: restoreAllUrl,
          type: 'POST',
          data:{'action':action,'ids':allVals},
          dataType:'JSON',
          success:(result)=>{
            getData(result.getDataUrl);
            swalWithBootstrapButtons.fire({
              text: result.message,
              showConfirmButton:false,
              timer: 3000,
              timerProgressBar: true,
            }).then((result)=>{
              $("#pillsTab a[href='#live']").tab('show');
            })
          }
        });
      }
  }); 
}

// move to Delete single record by just pass the url of 
function changeStatus(changeServiceURL,id,status,msg,BtnText,refresh = false,moveTo = false){
  swalWithBootstrapButtons.fire({
      text: msg,
      showCancelButton: true,
      confirmButtonText: BtnText,
      cancelButtonText: 'Not Yet!',
      reverseButtons: true,
      showCloseButton : true,
      allowOutsideClick:false,
    }).then((result)=>{
      var action = (result.value) ? 'trash' : 'delete';
      if(result.value == true){
        $.ajax({
          url: changeServiceURL,
          type: 'POST',
          data:{'id':id,'status':status},
          dataType:'JSON',
          success:(result)=>{
            getData(result.getDataUrl);
            if(refresh == true){
              window.location.reload();
            }
            swalWithBootstrapButtons.fire({
              text: result.message,
              showConfirmButton:false,
              timer: 3000,
              timerProgressBar: true,
            }).then((result)=>{
              if(moveTo){
                $(moveTo).toggleClass('active').toggleClass('show');
              }
            })
          }
        });
      }
    });
}
function exportButtons(type) {
  var actionBtn = (type == "pdf") ? "exportPdfActionBtn" : "exportExcelActionBtn";
  return `<div data-type="`+type+`">
  <p>Please Select Which Orders are you want to download?</p>
  <button class="btn btn-block btn-dark `+actionBtn+`" 
  data-href="/admin/export/`+type+`/New/orders">New Orders Only</button> 
  <button class="btn btn-block btn-dark `+actionBtn+`" 
  data-href="/admin/export/`+type+`/Process/orders">Pack Orders Only</button> 
  <button class="btn btn-block btn-dark `+actionBtn+`" 
  data-href="/admin/export/`+type+`/Dispatch/orders">In-Shipment Orders Only</button> 
  <button class="btn btn-block btn-dark `+actionBtn+`" 
  data-href="/admin/export/`+type+`/Complete/orders">Compelte Orders Only</button> 
  <button class="btn btn-block btn-dark `+actionBtn+`" 
  data-href="/admin/export/`+type+`/Cancel/orders">Cancel Orders Only</button> 
  <button class="btn btn-block btn-dark `+actionBtn+`" 
  data-href="/admin/export/`+type+`/All/orders">Download All Orders</button> 
</div>`;
}
function modelWithOption(type){
  var buttons = exportButtons(type);
  var fileType = type.toUpperCase();
  Swal.fire({
    icon: 'question',
    title: 'Download as '+fileType,
    html:buttons,
    showCloseButton: true,
    showCancelButton: false,
    showConfirmButton: false,
  });
}
/*
**
** editional events and functionality
**
*/
$(document).ready(function(){

  $('body').tooltip({
    selector: '[data-toggle="tooltip"]'
  });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //single record move to trash
  $(document).on('click','a.move-to-trash',function(){
    var trashRecordUrl = $(this).data('href');
    moveToTrashOrDelete(trashRecordUrl);
  });

  //single record move to delete
  $(document).on('click','a.delete',function(){
    var trashRecordUrl = $(this).data('href');
    moveToDelete(trashRecordUrl);
  });

  //select all checkboxes
  checkbox("#master",".sub_chk",'#apply');
  checkbox("#rst_master",".rst_sub_chk",'#rst_apply');

 //changeServiceStatus
  $(document).on('click','a.changeServiceStatus',function(){
    var id = $(this).data('id');
    var status = $(this).data('statusto');
    var changeServiceURL = $(this).data('href');
    var btnText = $(this).data('btntext');
    var msg = "You Want to Change Status of the Booking?";
    changeStatus(changeServiceURL,id,status,msg,btnText);
  });

  //changeOrderStatus
  $(document).on('click','a.changeOrderStatus',function(){
    var id = $(this).data('orderid');
    var status = $(this).data('statusto');
    var changeServiceURL = $(this).data('href');
    var btnText = $(this).data('btntext');
    var msg = "You Want to Change Status of the Order?";
    var refresh = $(this).data('refresh');
    changeStatus(changeServiceURL,id,status,msg,btnText,refresh);
  });

  //changeErrandStatus
  $(document).on('click','a.changeErrandStatus',function(){
    var id = $(this).data('id');
    var status = $(this).data('statusto');
    var changeServiceURL = $(this).data('href');
    var btnText = $(this).data('btntext');
    var msg = "You Want to Change Status of the Errand?";
    var moveTo = $(this).data('moveto');
    changeStatus(changeServiceURL,id,status,msg,btnText,true,moveTo);
  });
  
  $(document).on('click','a.changeFoodOrderStatus',function(){
    var id = $(this).data('foodorderid');
    var status = $(this).data('statusto');
    var changeOrderURL = $(this).data('href');
    var btnText = $(this).data('btntext');
    var msg = "You Want to Change Status of the Order?";
    var refresh = $(this).data('refresh');
    changeStatus(changeOrderURL,id,status,msg,btnText,refresh);
  });

  //selected record move to trash
  $(document).on('click','.move-to-trash-all', function(e) {
    e.preventDefault();
    var trashAllRecordUrl = $(this).data('href');
    moveToTrashAllOrDelete(trashAllRecordUrl);  
  });

  //selected record move to trash
  $(document).on('click','.move-to-delete-all', function(e) {
    e.preventDefault();
    var deleteAllRecordUrl = $(this).data('href');
    moveToDeleteAll(deleteAllRecordUrl);  
  });

  //single record restore
  $(document).on('click','a.trashed-records',function(){
    var restoreUrl = $(this).data('href');
    restore(restoreUrl);
  });

  //selected record restore
  $(document).on('click','.restore-all',function(){
    var restoreAllUrl = $(this).data('href');
    restoreAll(restoreAllUrl);
  });

  //move to trash datatable
  $(document).on('click','a.move-to-trash-dt',function(){
    var trashRecordUrl = $(this).data('href');
    moveToTrashOrDeleteDT(trashRecordUrl);
  });

  //export pdf list
  $(document).on('click','.exportAsPdfBtn',function(){
    modelWithOption('pdf');
  });
  $(document).on('click','.exportPdfActionBtn',function(){
    var href = $(this).data('href');
    window.open(href,"_blank","width=300,height=100");
    swalWithBootstrapButtons.fire({
      text: "PDF Downloading start.",
      showConfirmButton:false,
      timer: 3000,
      timerProgressBar: true,
    })
  });
  //export excel list
  $(document).on('click','.exportAsExcelBtn',function(){
    modelWithOption('excel');
  });
  $(document).on('click','.exportExcelActionBtn',function(){
    var href = $(this).data('href');
    window.open(href,"_self","width=300,height=100");
    swalWithBootstrapButtons.fire({
      text: "Excel Downloading start.",
      showConfirmButton:false,
      timer: 3000,
      timerProgressBar: true,
    })
  });



});

function getDateTimeForFile(){
  return moment().format('Do-MMMM-YYYY_h-mm-ss_A');
}

let dataTableCustomButtons = (title) => {
  return [
             {
                extend: 'copyHtml5',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
                className: "btn btn-secondary",
                title: title+' Copy_'+getDateTimeForFile(),
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                className: "btn btn-secondary",
                title: title+' Excel_'+getDateTimeForFile(),
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
                className: "btn btn-secondary",
                title: title+' CSV_'+getDateTimeForFile(),
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
                className: "btn btn-secondary",
                title: title+' PDF_'+getDateTimeForFile(),
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
                className: "btn btn-secondary",
                title: title+' Print_'+getDateTimeForFile(),
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }
        ];
}

let dataTableCustomButtonsWithAllCols = (title) => {
  return [
             {
                extend: 'copyHtml5',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
                className: "btn btn-secondary",
                title: title+' Copy_'+getDateTimeForFile()
            },
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                className: "btn btn-secondary",
                title: title+' Excel_'+getDateTimeForFile()
            },
            {
                extend: 'csvHtml5',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
                className: "btn btn-secondary",
                title: title+' CSV_'+getDateTimeForFile()
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF',
                className: "btn btn-secondary",
                title: title+' PDF_'+getDateTimeForFile()
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
                className: "btn btn-secondary",
                title: title+' Print_'+getDateTimeForFile()
            }
        ];
}

const commonDataTablePropsWithAllCols = (data) => {
  return {
        pagingType:"full_numbers",
        pageLength:50,
        autoWidth: false,
        lengthMenu: [ 
            [10, 25, 50, 100,-1], 
            ['10 rows', '25 rows', '50 rows', '100 rows', "All rows"] 
        ],
        buttons: dataTableCustomButtonsWithAllCols(data.title),
    }
}

const commonDataTableProps = (data) => {
  return {
        pagingType:"full_numbers",
        pageLength:50,
        autoWidth: false,
        lengthMenu: [ 
            [10, 25, 50, 100,-1], 
            ['10 rows', '25 rows', '50 rows', '100 rows', "All rows"] 
        ],
        buttons: dataTableCustomButtons(data.title),
    }
}

function setDateRangePicker(selectorId,data,callbackFn){
  $('#'+selectorId).daterangepicker({
    "showWeekNumbers": true,
    "alwaysShowCalendars": true,
    "startDate" : data.startDt,
    "endDate" : data.endDt,
    locale: {
        format: 'MMM D, YYYY',
        cancelLabel: 'Clear'
    },
    ranges   : {
        'Today'       : [moment(), moment()],
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'This Week'  : [moment().startOf('week'), moment().endOf('week')],
        'Last Week'  : [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'This Year'  : [moment().startOf('year'), moment().endOf('year')],
        'Last year'  : [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
    },
    // startDate: moment().startOf('day'),
    // endDate  : moment().endOf('day')
  },callbackFn);
}

 function sendNoticationCustom(id){
  $.ajax({
          type: "GET",
          url: '/management/send_custom_notifications/'+id,
          beforeSend: function(){ 
            $(".loader,.progress,.overlay").toggleClass('hidden');
          },
          complete: function(){ 
            // $('#post_tr'+id).preloader('remove');
            $(".loader,.progress,.overlay").toggleClass('hidden');
          },
          success: function (data) {
            if(data.error){
                showToast('Error',data.error,'error');
                return false;
              }else{
                showToast('Done!',data,'success');
                $('.sentnotification_'+id).remove();
              }
          },
      });
}


$(".ajax_users_all_search").select2({
    ajax: { 
      url: "/management/ajax_users_all_services",
      type: "GET",
      dataType: 'json',
      delay: 250,
      data: function (params) {
    
      return {
        name: params.term // search term
      };
      },
      processResults: function (users) {
        return {
          results:  $.map(users, function (item) {
                return {
                    text: "("+ item.username+")",
                    id: item.id_yangu
                }
            })
        };
      },
      cache: true
    },
    minimumInputLength: 1,
  });

$(document).on("change",".ajax_users_all_search",function(){
  var id = $(this).val();
  var url = $(this).data('url');
  url = url.replace(":id",id);
  window.location = url;//"/management/view_user_route/"+id;
})