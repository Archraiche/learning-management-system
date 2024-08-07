<?php
include('includes/admin_session.php');
include('dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow newtopbar" style="margin-bottom:0;">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4" style="margin-top: 27px; margin-left: 10px;">
                <h1 class="h3 mb-0 text-gray-800">Strands</h1>
            </div>


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <?php include('includes/admin_name.php'); ?>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="card-body">

            <div class="table-responsive">

                <td>
                    <!--Add Pop Up Modal -->
                    <div class="modal fade" id="add_class" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Section</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="manage-class-function.php" method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="add_ID" id="add_ID">

                                        <div class="form-group">
                                            <label for="strand">Track / Strand</label>
                                            <select type="text" class="form-control" id="strand" name="strand" required placeholder="Enter Strand Type">
                                                <option class="form-control" disabled selected> Select Track / Strand </Option>
                                                <option class="form-control" value="Academic-ABM"> Academic-ABM </Option>
                                                <option class="form-control" value="Academic-HUMSS"> Academic-HUMSS </Option>
                                                <option class="form-control" value="TVL-ICT"> TVL-ICT </Option>
                                                <option class="form-control" value="TVL-HE"> TVL-HE </Option>
                                                <option class="form-control" value="TVL-CSS"> TVL-CSS </Option>
                                                <option class="form-control" value="TVL-ANIMATION"> TVL-Animation </Option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="class_name">Section Name</label>
                                            <input type="text" class="form-control" id="class_name" name="class_name" required placeholder="Enter Class Name">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_class" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                            </div> <!--modal content -->
                        </div> <!--modal dialog -->
                    </div> <!--modal fade -->

                    <!-- <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_class" 
                            style="margin-bottom: 20px;"><i class="fa fa-plus" aria-hidden="true"></i> Add Section</button> -->
                </td>



                <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                    <h1 class="h5 mb-0 text-gray-800">Strand List</h1>
                </div>
                <?php
                //Displaying data into tables
                $query = "SELECT * FROM strand order by id DESC";
                $query_run = mysqli_query($conn, $query);
                ?>
                <table id="dataTableID" class="table table-bordered table table-striped" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Strand</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_assoc($query_run)) {
                        ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['full_name_strand']; ?></td>
                                    <td><?php if ($row['status'] == 1) { ?>
                                            <p>Active</p>
                                        <?php
                                        } else { ?>
                                            <p>Inactive</p>
                                        <?php
                                        } ?>
                                    </td>
                                    <td width="15%"><a href="manage-class.php?class_name=<?php echo urlencode($row['full_name_strand']); ?>" class="btn btn-secondary">View Section List</a></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "No Record Found";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>



        <?php
        include('includes/scripts.php');
        include('includes/footer.php');
        ?>





        <script>
            $(document).ready(function() {

                $('.edit_btn').on('click', function() {

                    $('#editProcessModal').modal('show');

                    $tr = $(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();

                    console.log(data);

                    //ID attribute ang kinukuha
                    $('#edit_ID').val(data[0]);
                    $('#o_ID').val(data[1]);
                    $('#edit_Process_Name').val(data[2]);
                    $('#edit_Process_Description').val(data[3]);
                    $('#edit_Process_Type').val(data[4]);
                });
            });
        </script>