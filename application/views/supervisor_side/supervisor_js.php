<!-- swal alert -->
<script src="<?php echo base_url('assets/js/dataTables.fixedHeader.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2@11.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2.min.js'); ?>"></script>


<script>
  
function display_cashier_violation_js()
{
    // for not disapear modal in clicking outside of the modal
    $('#modal_loader').modal({
        backdrop: 'static',
        keyboard: false
		});
		// =================================================================
		$("#modal_loader").show();
		// =================================================================
    var cutoff_date = $("#cutoff_date").val().split(' to ');
    var dtfrom = new Date(cutoff_date[0]);
    var dtto = new Date(cutoff_date[1]);
    var dt_from = [String(dtfrom.getMonth() + 1).padStart(2, '0'), String(dtfrom.getDate()), dtfrom.getFullYear()].join('-');
    var dt_to = [String(dtto.getMonth() + 1).padStart(2, '0'), String(dtto.getDate()), dtto.getFullYear()].join('-');

    $('#divbody_cashier_violation_table').html('');
    $.ajax({
      type: 'post',
      url: '<?php echo base_url(); ?>display_cashier_violation_route',
      data: {'dt_from': dt_from,
             'dt_to': dt_to
            },
      dataType: 'json',
      success: function(data) {
          if(data=='EXPIRED SESSION')
          {
              Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
            
              setTimeout(function() {
                window.parent.location.href = "<?php echo base_url() ?>supervisor_cashier_violation_route";
              }, 1000);
          }
          else
          {
              $('#divbody_cashier_violation_table').html(data.html);
              if(data.html != '')
              {
                $("#modal_loader").hide();
                cashier_violation_datatable();
              }
          }
      }
    });
}

function cashier_violation_datatable() 
{
  /*sort datatable*/
  $(document).ready(function() {
    $('#cashier_violation_table').DataTable({
      // retrieve: true,
      "columnDefs": 
      [
        {"className": "text-center", "targets": [0,1,2,3,4,5,6,7,8]}
      ],
      "order": [
        [3, "asc"]
      ] // OR  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    });
  });
}

function display_forwarded_violation_js()
{
  var fromdate = $("#dtfrom").val();
  var todate = $("#dtto").val();

  if ((fromdate == "") || (todate == "")) {
    $("#result").html("Please enter two dates");
    return false
  }

  var dt1 = new Date(fromdate);
  var dt2 = new Date(todate);

  var time_difference = dt2.getTime() - dt1.getTime();
  var number_of_days = time_difference / (1000 * 60 * 60 * 24);
  // ==================================================================================================================================
  if($("#dtfrom").val() > $("#dtto").val())
  {
    Swal.fire('INVALID DATE', 'FROM is never greather than to TO.', 'error')
    return;
  }
  else if(number_of_days > 30)
  {
    Swal.fire('INVALID DATE', 'You\'ve reached the maximum date range, not greather than 30 days to avoid loading or lag of PC.', 'error')
    return;
  }
  else
  {
    $('#divbody_forwarded_violation_table').html('');
    $.ajax({
      type: 'post',
      url: '<?php echo base_url(); ?>display_forwarded_violation_route',
      data: {'dtfrom': $("#dtfrom").val(),
             'dtto': $("#dtto").val()
            },
      dataType: 'json',
      success: function(data) {
        if(data=='EXPIRED SESSION')
        {
            Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
          
            setTimeout(function() {
              window.parent.location.href = "<?php echo base_url() ?>supervisor_cashier_violation_route";
            }, 1000);
        }
        else
        {
            $('#divbody_forwarded_violation_table').html(data.html);
            forwarded_violation_datatable_v2();
        }
      }
    });
  }
}

function forwarded_violation_datatable() 
{
  /*sort datatable*/
  $(document).ready(function() {
    $('#forwarded_violation_table').DataTable({
      // retrieve: true,
        dom: 'Bfrtip',
         buttons: [
            // 'copy', 'csv', 'excel', 'pdf', 'print'
            {
                extend: 'collection',
                text: 'Export',
                buttons: [
                     {
                        extend: 'copy',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 , 7, 8, 9 ]
                        }
                      },
                      {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 , 7, 8, 9 ]
                        }
                      },
                      {
                        extend: 'excel',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 , 7, 8, 9 ]
                        }
                      },
                      /*{
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                        }
                      },*/
                      {
                        extend: 'print',
                        title: '<h2 style="font-family: Georgia, serif; font-weight: bold;"><center>CS LIQUIDATION<center></h2>',
                        customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' );
                           /* .prepend(
                                '<img src="<?php echo base_url(); ?>assets/image/alturas_logo.png" style="position:absolute; top:0; left:0;" />'
                            );*/

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                        },
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 ]
                        }
                      }
                ]
            }
        ],
      "columnDefs": 
      [
        {"className": "text-center", "targets": [0,1,2,3,4,5,6,7,8,9]}
      ],
      "order": [
        [9, "asc"]
      ] // OR  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    });
  });
}

function forwarded_violation_datatable_v2() 
{
  /*sort datatable*/
  $(document).ready(function() {
    $('#forwarded_violation_table').DataTable({
      // retrieve: true,
      "columnDefs": 
      [
        {"className": "text-center", "targets": [0,1,2,3,4,5,6,7,8,9]}
      ],
      "order": [
        [9, "asc"]
      ] // OR  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    });
  });
}

function submit_violation_js()
{
    // =================================================================================================
    var check = $("input[class='check_box']:checked").map(function() {
      return this.value;
    }).get();
    // =================================================================================================
    if(check == '')
    {
      Swal.fire('MISSING DATA', 'Please select cashier violation before click submit button.', 'error')
      return;
    }
    else
    {
      Swal.fire({
        title: 'Are you sure you want to submit violation?',
        icon: 'warning',
        showDenyButton: true,
        /* showCancelButton: true,*/
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
        actions: 'my-actions',
        /*  cancelButton: 'order-1 right-gap',*/
        confirmButton: 'order-2',
        denyButton: 'order-3',
        }
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
              type: 'post',
              url: '<?php echo base_url(); ?>submit_violation_route',
              data: {'id': check},
              dataType: 'json',
              success: function(data) {
                if(data=='EXPIRED SESSION')
                {
                    Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
                  
                    setTimeout(function() {
                      window.parent.location.href = "<?php echo base_url() ?>supervisor_cashier_violation_route";
                    }, 1000);
                }
                else
                {
                    display_forwarded_violation_js();
                    display_cashier_violation_js();
                    Swal.fire('SUBMITTED', '', 'success')
                }
              }
          });
        } else if (result.isDenied) {
          Swal.fire('CANCELLED', '', 'info')
        }
      }) 
    }
}

function uncheck_checkall_js()
{
    document.getElementById("checkAll").checked = false;
}

function get_bunit_js()
{
  $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>get_bunit_route',
        dataType: 'json',
        success: function(data) 
        {
          $('#bunit_name').html(data.bunit_name);
          display_department_js();
          display_payment_list_js();
        }
  });
}

 function get_bunit_js_v2()
 {
    $.ajax({
          type: 'post',
          url: '<?php echo base_url(); ?>get_bunit_route_v2',
          dataType: 'json',
          success: function(data) 
          {
            $('#bunit_name').html(data.bunit_name);
            display_department_js();
            display_payment_list_js();
          }
    });
 }

 function update_get_bunit_js()
 {
    $.ajax({
          type: 'post',
          url: '<?php echo base_url(); ?>mop_get_bunit_name_route',
          dataType: 'json',
          success: function(data) 
          {
            $('#bunit_name').html(data.bunit_name);
            display_department_js();
            display_payment_list_js();
          }
    });
 }

 function display_department_js()
 {
      $('#tr_mop').html('');
      $('#th_checkbox').prop('checked', false);
      $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>display_department_route',
            data:{'bunit_code': $('#bunit_name').val()},
            dataType: 'json',
            success: function(data) {
              $('#dept_name').html(data.dept_name);
            }
      });
 }

 function get_deptcode_js()
 {
     $("#dept_code").val($("#dept_name").val())
 }

 function save_payment_js()
 {
      // console.log($("#bunit_name").val(),$("#dept_name").val());
    Swal.fire({
      title: 'Are you sure you want to save?',
      icon: 'warning',
      showDenyButton: true,
      /* showCancelButton: true,*/
      confirmButtonText: 'Yes',
      denyButtonText: 'No',
      customClass: {
        actions: 'my-actions',
        /*  cancelButton: 'order-1 right-gap',*/
        confirmButton: 'order-2',
        denyButton: 'order-3',
      }
    }).then((result) => {
      if (result.isConfirmed) {

        if($("#ap_type option:selected").text() == 'Select Type')
        {
            Swal.fire('MISSING DATA', 'Please select type before save', 'error')
            return;
        }
        else if($("#ap_mop").val() == '')
        {
            Swal.fire('MISSING DATA', 'Please input mode of payment before save', 'error')
            return;
        }
        else
        {
            $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>save_payment_route',
            data: {'type': $("#ap_type").val(),
                   'mop': $("#ap_mop").val().toUpperCase(),
                   'bunit_code': $("#bunit_name").val(), 
                   'dept_code': $("#dept_name").val() 
            },
            dataType: 'json',
            success: function(data)
            {
                if(data=='EXPIRED SESSION')
                {
                   Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
                 
                   setTimeout(function() {
                     window.parent.location.href = "<?php echo base_url() ?>supervisor_add_payment_route";
                    }, 1000);
                }
                else if(data == 'ALREADY EXIST')
                {
                  Swal.fire('ALREADY EXIST', '', 'error')
                  return;
                }
                else
                {
                    Swal.fire('SAVED', '', 'success')
                 
                   setTimeout(function() {
                     window.parent.location.href = "<?php echo base_url() ?>supervisor_add_payment_route";
                    }, 1000);
                }
            }
        });
        }

      } else if (result.isDenied) {
        Swal.fire('CANCELLED', '', 'info')
      }
    })
 }

 function save_payment_js_v2()
 {
    var check = $("input[class='td_checkbox enable']:checked").map(function() {
                  return this.value;
                }).get();
          
    if($("#bunit_name option:selected").text() == 'Select Business Unit')
    {
        Swal.fire('MISSING BUSINESS UNIT', 'Please select business unit before save', 'error')
        return;
    }
    else if($("#dept_name option:selected").text() == 'Select Department')
    {
        Swal.fire('MISSING DEPARTMENT', 'Please select department before save', 'error')
        return;
    }
    else if(check == '')
    {
      Swal.fire('NO SELECTED', 'Please select mode of payment before save', 'error');
      return;
    }
    else
    {
        Swal.fire({
        title: 'Are you sure you want to save?',
        icon: 'warning',
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
        actions: 'my-actions',
        confirmButton: 'order-2',
        denyButton: 'order-3',
        }
        }).then((result) => {
          if (result.isConfirmed) {

                $.ajax({
                    type: 'post',
                    url: '<?php echo base_url(); ?>save_payment_route_v2',
                    data: {'bcode': $("#bunit_name option:selected").val(),
                           'dcode': $("#dept_name option:selected").val(),
                           'mop_data': check
                    },
                    dataType: 'json',
                    success: function(data)
                    {
                        if(data=='EXPIRED SESSION')
                        {
                          Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
                        
                          setTimeout(function() {
                            window.parent.location.href = "<?php echo base_url() ?>supervisor_add_payment_route_v2";
                          }, 1000);
                        }
                        else
                        {
                            $("#tr_mop").html('');
                            $("#th_checkbox").prop('checked', false);
                            display_payment_list_js();
                            Swal.fire('SAVED', '', 'success')
                            display_mop_js();
                        }
                    }
                });

          } else if (result.isDenied) {
            Swal.fire('CANCELLED', '', 'info')
          }
        })
    }
 }

 function cancel_js()
 {
    Swal.fire({
    title: 'Are you sure you want to cancel?',
    icon: 'warning',
    showDenyButton: true,
    /* showCancelButton: true,*/
    confirmButtonText: 'Yes',
    denyButtonText: 'No',
    customClass: {
    actions: 'my-actions',
    /*  cancelButton: 'order-1 right-gap',*/
    confirmButton: 'order-2',
    denyButton: 'order-3',
    }
    }).then((result) => {
      if (result.isConfirmed) 
      {

        window.parent.location.href = "<?php echo base_url() ?>supervisor_add_payment_route_v2"; 
     
      } else if (result.isDenied) {
        Swal.fire('CANCELLED', '', 'info')
      }
    })
 }

 function display_payment_list_js()
 {
    $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>display_payment_list_route',
            dataType: 'json',
            success: function(data) {
              $('#div_payment_list').html(data.html);
              paymentlist_datatable();
            }
    });
 }

 function paymentlist_datatable() 
{
  /*sort datatable*/
  $(document).ready(function() {
    $('#payment_list_table').DataTable({
      "columnDefs": 
      [
        {"className": "text-center", "targets": [0,1,2,3]}
      ],
      "order": [
        [0, "asc"]
      ] // OR  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    });
  });
}

function delete_mop_js(id,type,mop,dcode,bname,dname)
{
    Swal.fire({
    title: mop+' / '+type+'<br>'+bname+'<br>'+dname,
    text: 'Are you sure you want to delete?',
    icon: 'warning',
    showDenyButton: true,
    /* showCancelButton: true,*/
    confirmButtonText: 'Yes',
    denyButtonText: 'No',
    customClass: {
    actions: 'my-actions',
    /*  cancelButton: 'order-1 right-gap',*/
    confirmButton: 'order-2',
    denyButton: 'order-3',
    }
    }).then((result) => {
      if (result.isConfirmed) 
      {
        $.ajax({
                type: 'post',
                url: '<?php echo base_url(); ?>delete_mop_route',
                data:{'id': id,
                      'type': type,
                      'mop': mop,
                      'dcode': dcode
                     },
                dataType: 'json',
                success: function(data) {
                  
                  if(data=='EXPIRED SESSION')
                  {
                     Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
                   
                     setTimeout(function() {
                       window.parent.location.href = "<?php echo base_url() ?>supervisor_add_payment_route";
                      }, 1000);
                  }
                  else
                  {
                      display_mop_js();
                      display_payment_list_js();
                      Swal.fire('DELETED', '', 'success')
                  }
                }
              });
     
      } else if (result.isDenied) {
        Swal.fire('CANCELLED', '', 'info')
      }
    })
}

function disabled_select_dept_js()
{
  $("#dept_option").prop('disabled', true);
}

function disabled_select_bu_js()
{
  $("#bu_option").prop('disabled', true);
}

function display_mop_js()
{
  $("#th_checkbox").prop( "checked", false );
  $("#save_btn").prop( "disabled", false );
  if($("#bunit_name").val() != 'Select Business Unit')
  {
      $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>display_sup_mop_route',
            data: {'bcode': $("#bunit_name").val(),
                    'dcode': $("#dept_name").val()
            },
            dataType: 'json',
            success: function(data) {
                $('#tr_mop').html(data.html);
                if (data.th_checkbox == "ENABLED") {
                    $("#th_checkbox").prop( "disabled", false );
                }
                else
                {
                    $("#th_checkbox").prop( "disabled", true );
                    $("#save_btn").prop( "disabled", true );
                }
            }
      });
  }
}

function th_checked_js()
{
  if($("#th_checkbox").prop("checked") == true)
  {
      $(".td_checkbox").prop( "checked", true );  
      $(".unchecked").prop( "checked", false );  
  }
  else
  {
      $(".td_checkbox").prop( "checked", false );
      $(".unchecked").prop( "checked", false );
  }
}

function view_cashier_denomination_js()
{
  $('#divbody_transferred_dentable').html('');
  $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>view_cashier_denomination_route',
        data: {'date': $("#filter_date").val()},
        dataType: 'json',
        success: function(data) {
          $('#divbody_transferred_dentable').html(data.html);
          cashier_denomination_datatable();
        }
  });
}

function cashier_denomination_datatable() 
{
  $(document).ready(function() {
    $('#transferred_den_table').DataTable({
      "columnDefs": 
      [
        {"className": "text-center", "targets": [0,1,2,3,4,5,6,7,8,9]}
      ],
      "order": [
        [3, "desc"], [0, "asc"]
      ] // OR  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    });
  });
}

function view_pending_denomination_js()
{
  $('#divbody_pending_dentable').html('');
  $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>view_pending_denomination_route',
        data: {'date': $("#filter_date").val()},
        dataType: 'json',
        success: function(data) {
          $('#divbody_pending_dentable').html(data.html);
          pending_denomination_datatable();
        }
  });
}

function pending_denomination_datatable() 
{
  $(document).ready(function() {
    $('#pending_den_table').DataTable({
      "columnDefs": 
      [
        {"className": "text-center", "targets": [0,1,2,3,4,5,6,7]}
      ],
      "order": [
        [3, "desc"], [0, "asc"]
      ] // OR  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    });
  });
}

function view_cashier_deleted_denomination_js()
{
  $('#divbody_transferred_dentable').html('');
  $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>view_cashier_deleted_denomination_route',
        dataType: 'json',
        success: function(data) {
          $('#divbody_transferred_dentable').html(data.html);
          deleted_cashier_denomination_datatable();
        }
  });
}

function deleted_cashier_denomination_datatable() 
{
  $(document).ready(function() {
    $('#deleted_denomination_table').DataTable({
      "columnDefs": 
      [
        {"className": "text-center", "targets": [0,1,2,3,4,5,6,7,8,9,10]}
      ],
      "order": [
        [10, "desc"], [0, "asc"]
      ] // OR  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    });
  });
}

function view_cashier_deleted_pending_denomination_js()
{
  $('#divbody_deleted_pending_dentable').html('');
  $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>view_cashier_deleted_pending_denomination_route',
        dataType: 'json',
        success: function(data) {
          $('#divbody_deleted_pending_dentable').html(data.html);
          deleted_cashier_pending_denomination_datatable();
        }
  });
}

function deleted_cashier_pending_denomination_datatable() 
{
  $(document).ready(function() {
    $('#deleted_denomination_table').DataTable({
      "columnDefs": 
      [
        {"className": "text-center", "targets": [0,1,2,3,4,5,6,7,8,9,10]}
      ],
      "order": [
        [10, "desc"], [0, "asc"]
      ] // OR  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    });
  });
}

function cancel_denomination_js(tr_no,emp_id,sscode,pos_name,date)
{
  var title = '<span style="color: red;">WARNING!</span>';
  Swal.fire({
  title: title,
  text: 'Deleting cashier denomination cannot be undo, after delete please inform cashier and liquidation officer to input the correct denomination, are you sure you want to delete this cashier denomination?',
  icon: 'warning',
  showDenyButton: true,
  confirmButtonText: 'Yes',
  denyButtonText: 'No',
  customClass: {
  actions: 'my-actions',
  confirmButton: 'order-2',
  denyButton: 'order-3',
  }
  }).then((result) => {
    if (result.isConfirmed) 
    {
        $.ajax({
          type: 'post',
          url: '<?php echo base_url(); ?>cancel_denomination_route',
          data: {'tr_no': tr_no,
                  'emp_id': emp_id,
                  'sscode': sscode,
                  'pos_name': pos_name,
                  'date': date
          },
          dataType: 'json',
          success: function(data) {
            if(data=='EXPIRED SESSION')
            {
                Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
              
                setTimeout(function() {
                  window.parent.location.href = "<?php echo base_url() ?>sup_cashier_denomination_route";
                }, 1000);
            }
            else if(data.message == 'ALREADY EXIST')
            {
              Swal.fire('INVALID DELETE', 'You cannot delete multiple denomination of cashier, please input first the deleted denomination on <span style="font-weight: bold;">'+data.sales_date+'</span> before delete another denomination.', 'error')
            }
            else
            {
              view_cashier_denomination_js();
              Swal.fire('DELETED', 'Please inform cashier and liquidation officer to input the correct denomination.', 'success')
            }
          }
        });
    } else if (result.isDenied) {
      Swal.fire('CANCELLED', '', 'info')
    }
  })
}

function cancel_pending_denomination_js(id)
{
  var title = '<span style="color: red;">WARNING!</span>';
  Swal.fire({
  title: title,
  text: 'Deleting cashier denomination cannot be undo, are you sure you want to delete this cashier denomination?',
  icon: 'warning',
  showDenyButton: true,
  confirmButtonText: 'Yes',
  denyButtonText: 'No',
  customClass: {
  actions: 'my-actions',
  confirmButton: 'order-2',
  denyButton: 'order-3',
  }
  }).then((result) => {
    if (result.isConfirmed) 
    {
        $.ajax({
          type: 'post',
          url: '<?php echo base_url(); ?>cancel_pending_denomination_route',
          data: {'id': id},
          dataType: 'json',
          success: function(data) {
            if(data=='EXPIRED SESSION')
            {
                Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
              
                setTimeout(function() {
                  window.parent.location.href = "<?php echo base_url() ?>sup_cashier_denomination_route";
                }, 1000);
            }
            else
            {
              view_pending_denomination_js();
              Swal.fire('DELETED', 'Please inform cashier and liquidation officer to input the correct denomination.', 'success')
            }
          }
        });
    } else if (result.isDenied) {
      Swal.fire('CANCELLED', '', 'info')
    }
  })
}

function get_cutoff_date_js()
{
    $.ajax({
      type: 'post',
      url: '<?php echo base_url(); ?>get_cutoff_date_route',
      dataType: 'json',
      success: function(data) {
        $("#cutoff_date").html(data.cutoff_date_html);
        display_cashier_violation_js();
      }
    });
}


</script>