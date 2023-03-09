<!-- swal alert -->
<script src="<?php echo base_url('assets/js/dataTables.fixedHeader.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2@11.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweetalert2.min.js'); ?>"></script>


<script>
  

 function display_bunit_js()
 {
    // console.log($('#bunit_code').val());
    $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>display_bunit_route',
            dataType: 'json',
            success: function(data) {
              $('#bunit_name').html(data.bunit_name);
            }
          });
 }

 function get_bunitcode_js()
 {
    console.log($('#bunit_name').val());
 }

 function search_emp_js()
 {
    var availableTags = [];

    $.ajax({
        type: 'post',
        url: '<?php echo base_url(); ?>search_emp_route',
        data: {'emp_name': $("#emp_name").val()},
        dataType: 'json',
        success: function(data) 
        {
          if(data=='EXPIRED SESSION')
          {
             Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
           
             setTimeout(function() {
               window.parent.location.href = "<?php echo base_url() ?>adduser_access_route";
              }, 1000);
          }
          else
          {
                availableTags = data.emp_name.split('^');
                // console.log(availableTags);
                $( "#emp_name" ).autocomplete({
                  source: availableTags
                });
          }
        }
      });
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
            Swal.fire('CANCELLED', '', 'info')
           
             setTimeout(function() {
               window.parent.location.href = "<?php echo base_url() ?>adduser_access_route";
              }, 1000);

      } else if (result.isDenied) {
        Swal.fire('CANCEL', '', 'info')
      }
    })
 }

 function addpayment_user_js()
 {
    Swal.fire({
    title: 'Are you sure you want to add?',
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
        
        // console.log($("#emp_name").val());
        $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>addpayment_user_route',
            data: {'emp_name': $("#emp_name").val()},
            dataType: 'json',
            success: function(data) 
            {
              if(data=='EXPIRED SESSION')
              {
                 Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
               
                 setTimeout(function() {
                   window.parent.location.href = "<?php echo base_url() ?>adduser_access_route";
                  }, 1000);
              }
              else if(data == 'INVALID EMPLOYEE')
              {
                Swal.fire('INVALID EMPLOYEE', 'Please select employee in search box', 'error')
              }
              else if(data == 'ALREADY EXIST')
              {
                 Swal.fire('ALREADY EXIST', '', 'error')
              }
              else
              {
                 Swal.fire('ADDED', '', 'success')
               
                 setTimeout(function() {
                   window.parent.location.href = "<?php echo base_url() ?>adduser_access_route";
                  }, 1000);
              }
            }
          });

    } else if (result.isDenied) {
      Swal.fire('CANCELLED', '', 'info')
    }
  }) 
 }

 function display_user_js()
 {
    $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>display_user_route',
            dataType: 'json',
            success: function(data) {
                console.log(data.html);
              $('#div_user_list').html(data.html);
              addpayment_user_datatable();
            }
          });
 }

function addpayment_user_datatable() 
{
  /*sort datatable*/
  $(document).ready(function() {
    $('#addpayment_user_table').DataTable({
      // retrieve: true,
      "columnDefs": 
      [
        {"className": "text-center", "targets": [0,1]}
      ],
      "order": [
        [0, "asc"]
      ] // OR  order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    });
  });

}

 function delete_user_js(id,name)
 {
    Swal.fire({
    title: name,
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
    if (result.isConfirmed) {
        
        // console.log($("#emp_name").val());
        $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>delete_user_route',
            data: {'id': id},
            dataType: 'json',
            success: function(data) 
            {
              if(data=='EXPIRED SESSION')
              {
                 Swal.fire('EXPIRED SESSION', 'Please relogin your HRMS', 'error')
               
                 setTimeout(function() {
                   window.parent.location.href = "<?php echo base_url() ?>adduser_access_route";
                  }, 1000);
              }
              else
              {
                 Swal.fire('DELETED', '', 'success')
               
                 setTimeout(function() {
                   window.parent.location.href = "<?php echo base_url() ?>adduser_access_route";
                  }, 1000);
              }
            }
          });

    } else if (result.isDenied) {
      Swal.fire('CANCELLED', '', 'info')
    }
  }) 
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
            // display_payment_list_js();
          }
    });
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
 
</script>