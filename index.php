<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Datatable Server Side</title>

<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.min.css"/>

<script type="text/javascript" charset="utf8" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>

	
	<div class="container">
      <div class="">
        <div class="row">
          <div class="col-md-6">
            <h1>Data Table</h1>
          </div>
          
          <div class="col-md-6 p-2">
            <button class="btn btn-success float-right" id="refresh-btn">Refresh</button>
          </div>
        </div>
        <div class="">
      		<table id="employee_grid" class="display" width="100%" cellspacing="0">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
      				        <th>Salary</th>
                      <th>Age</th>
                      <th>Action</th>
                  </tr>
              </thead>
          </table>
        </div>
      </div>
  </div>

<script type="text/javascript">
$( document ).ready(function() {
initdatatable = $('#employee_grid').DataTable({
				 "bProcessing": true,
         "serverSide": true,
         "lengthMenu": [ 10, 25, 50, 100, 500 ],
         "pageLength": 10,
         "scrollX": true,
         "scrollY": 500,
         "ajax":{
            url :"response.php", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error: function(){
              $("#employee_grid_processing").css("display","none");
            }
          },
          "columns":[
              {"data": 0},
              {"data": 1},
              {"data": 2},
              {"data": 3},
              {"data": null,
                  render:function(data, type, row)
                  {
                    console.log(data);
                    return '<button id="actionButton" data-id="'+data[0]+'" type="button" class="btn btn-primary">Edit</button>';
                  },
              },
              //{"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm'><i class='material-icons'>delete</i></button></div></div>"}
          ],

          //////// 100,000 data load 2nd method ///////////////
          // "columns":[
          //     {"data": "user_id"},
          //     {"data": "username"},
          //     {"data": "gender"},
          //     {"data": "password"},
          //     {"data": null,
          //         render:function(data, type, row)
          //         {
          //           console.log(data);
          //           return '<button id="actionButton" data-id="'+data.user_id+'" type="button" class="btn btn-primary">Edit</button>';
          //         },
          //     },
          // ]
        });


        $(document).on("click", "#refresh-btn", function(){
          initdatatable.ajax.reload(); //call this for update after any action
        });

});
</script>
