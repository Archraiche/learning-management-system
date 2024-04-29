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
                <h1 class="h3 mb-0 text-gray-800">Manage Students</h1>
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
                    <div class="modal fade" id="add_studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="manage-students-function.php" method="POST">


                                    <div class="modal-body">

                                        <input type="hidden" name="add_ID" id="add_ID">
                                        <input type="hidden" name="user_type" id="user_type">

                                        <div class="form-group">
                                            <label for="#">Class - Section</label>
                                            <select name="class_id" class="form-control" required>
                                                <option value="" disabled selected>Select Class</option>
                                                <?php
                                                $query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_name");
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="#">Learner Reference Number (LRN)</label>
                                            <input type="text" class="form-control" id="add_student_number" name="lrn" maxlength="13" minlength="13" placeholder="Enter 12-Digit LRN" oninput="formatStudentNumber(this)" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="#">First Name</label>
                                            <input type="text" class="form-control" name="firstname" id="add_First_Name" placeholder="Enter First Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="#">Last Name</label>
                                            <input type="text" class="form-control" name="lastname" id="add_Last_Name" placeholder="Enter Last Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="#">Email</label>
                                            <input type="email" class="form-control" name="email" id="add_Email" placeholder="Enter email" required>
                                        </div>


                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="text" class="form-control flatpickr" id="dob" name="dob" required placeholder="Enter Date of Birth">
                                        </div>


                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="add_student" class="btn btn-primary">Submit</button>
                                    </div>
                                </form> <!--end form -->
                            </div> <!--modal content -->
                        </div> <!--modal dialog -->
                    </div> <!--modal fade -->

                    <!-- <button type="button" class="btn btn-success add_btn" data-toggle="modal" data-target="#add_studentModal" style="margin-bottom: 20px;"><i class="fa fa-plus" aria-hidden="true"></i> Add Students</button> -->
                </td>
                <!-- <div class="form-group">
                    <label>Add students via .csv file</label>
                    <form method="post" action="manage-students-csv.php" enctype="multipart/form-data">
                        <input type="file" id="csvFile" placeholder="Upload .csv file" name="file" accept=".csv" style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-right: 10px;">
                        <button type="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading..." id="uploadBtn" disabled>Upload</button>
                    </form>
                </div> -->

                <script>
                    document.getElementById('csvFile').addEventListener('change', function() {
                        const uploadBtn = document.getElementById('uploadBtn');
                        if (this.files.length !== 0 && this.files[0].name.endsWith('.csv')) {
                            uploadBtn.disabled = false;
                        } else {
                            uploadBtn.disabled = true;
                        }
                    });
                </script>



                <div class="d-sm-flex align-items-center justify-content-between mb-2" style="margin-top: 10px; margin-left: 10px;">
                    <h1 class="h5 mb-0 text-gray-800">Student List</h1>
                </div>
                <?php
                // Displaying data into tables with class_name
                $query = "SELECT student.*, class.class_name, strand.name as strand_name FROM student
                LEFT JOIN class ON student.class_id = class.class_id
                LEFT JOIN strand ON strand.id = student.strand_id 
                WHERE student.status=1 ORDER BY student.student_id DESC";
                
                $query_run = mysqli_query($conn, $query);
                ?>

                <table id="dataTableID" class="table table-bordered table table-striped "  width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="display:none;">Student ID</th>
                            <!-- <th>Photo</th> -->
                            
                            <th>Student I.D</th>
                            <th>LRN</th>
                            <th style="display:none;">Firstname</th>
                            <th style="display:none;">Lastname</th>
                            <th>Name</th>
                            <th>Strand</th>
                            <th>Section</th>
                            <th>Enrollment</th>
                            <th>Enrollment Date</th>
                            <th>Attachment</th>
                            <th>Approval</th>
                            <th>Status</th>
                            <!-- <th>Edit</th> -->
                            <th>Action</th>
                            <th>Action</th>


                            <!--<th colspan ="2">Action</th> Hindi pwedeng may colspan para sa dataTables-->
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_assoc($query_run)) {

                        ?>
                                <tr>

                                    <td style="display:none;"><?php echo $row['student_id']; ?></td>
                                    <!-- <td><img src="<?php echo $row['location']; ?>" alt="" class="rounded-circle d-block mx-auto" style="width: 60px;"></td> -->
                                    <td><?php if (empty($row['class_name'])){  echo "Enlisted"; } else{  echo $row['student_id'];}  ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><a href="profile.php?student_id=<?php echo $row['student_id']; ?>"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></a></td>
                                    <td style="display:none;"><?php echo $row['firstname']; ?></td>
                                    <td style="display:none;"><?php echo $row['lastname']; ?></td>
                                    <td><?php echo $row['strand_name']; ?></td>
                                    <td><?php
                                    /*
                                    if(empty($row['class_name']) && $row['is_regular'] == 1 ){
                                        echo "Need Approval";
                                    }elseif(empty($row['class_name']) && $row['is_regular'] == 3 ){
                                        echo "IRREGULAR";
                                    }elseif(empty($row['class_name']) && $row['is_regular'] == 2 ){
                                        echo "TRANSFEREE";
                                    }else{
                                        echo $row['class_name'];
                                    }
                                    */
                                        if(!empty($row['class_name'])){
                                            echo $row['class_name'];
                                        }else{
                                            echo "<b style='color:red'>For Approval</b>";
                                        }
                                    ?>
                                    </td>

                                    <td>
                                        <?php if ($row['is_regular'] == 1) { ?>
                                            <p>Regular</p>
                                        <?php } else {                        ?>
                                            <p>Irregular</p>
                                        <?php }                               ?>
                                    </td>
                                    <td>
                                        <?php echo $row['enrollment_date'] ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-secondary attachment-btn" data-student-id="<?php echo $row['student_id']; ?>" style="color:white">Attachment</button>
                                    </td>
                                    <td>
                                    <?php if (empty($row['password'])) {    ?>
                                            <button type="submit" name="approval" class="btn btn-success" style="background-color:#22DD22;color:white;border:none" data-toggle="modal" data-target="#approveModal" onclick="doapprovedModal(<?php echo $row['student_id']; ?>)">Approve</button>
                                    <?php } else {                           ?>
                                            <p>Approved</p>

                                    <?php  }                                ?>
                                    

                                    </td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 1) {
                                        ?>
                                            <p>Active</p>     
                                        <?php
                                        } else {
                                        ?>
                                            <p>Archived</p>
                                        <?php
                                        }
                                        ?>
                                    </td>

                                    <td>
                                    <?php
                                        if ($row['status'] == 1) {
                                        ?>
                                        <!--Delete Pop Up Modal -->
                                        <div class="modal fade" id="deletestudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Archive User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="manage-students-function.php" method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="delete_ID" id="delete_ID">
                                                            <h5>Do you want to archive this data?</h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="archivestudent" class="btn btn-primary">Confirm</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="delete_btn" class="btn btn-danger delete_btn">Archive</button>

                                       <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($row['grade_level']=="11" && !empty($row['password'])) { ?>
                                            <button  type="submit" name="" data-toggle="modal" data-target="#modalg12<?php echo $row['student_id']; ?>" class="btn btn-success" style="background-color:#22DD22;color:white;border:none;width:95px" data-toggle="modal" data-target="#" ><i class="fa fa-arrow-up  "></i> <br>Grade 12</button>
                                        <?php }else{ ?>
                                            <button  type="submit" name="" data-toggle="modal"  class="btn " style="background-color:gray;color:white;border:none;width:95px" data-toggle="modal" data-target="#" ><i class="fa fa-arrow-up  "></i> <br>Grade 12</button>
                                        <?php } ?>

                                        <div class="modal fade" id="modalg12<?php echo $row['student_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"><b>PROMOTE</b></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="manage-students-function.php" method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="student_id" id="student_id" value="<?php echo $row['student_id']  ?>">
                                                            
                                                            <h5>Promote <b><?php echo $row['firstname'] . " " . $row['lastname']?></b> to Grade 12</h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="movetograde12" class="btn btn-primary">Confirm</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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

        <!-- approved Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approve Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="manage-students-function.php" method="POST">


                        <div class="modal-body">

                            <input type="hidden" name="approvedinputid" id="approvedinputid">

                            <h5>Do you want to approve this student?</h5>



                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="approve_student" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="attachmentModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Attachments</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="attachmentList"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function doapprovedModal(id) {
                document.getElementById("approvedinputid").value = id;
            }
            

            $(document).ready(function() {
                $('.attachment-btn').click(function() {
                    var studentId = $(this).data('student-id');
                    
                    $.ajax({
                        url: 'fetch_attachments.php',
                        type: 'POST',
                        data: { student_id: studentId },
                        success: function(response) {
                            $('#attachmentList').html(response);
                            $('#attachmentModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });

            function setDeleteID(studentID) {
                document.getElementById("delete_ID1").value = studentID;
            }
        </script>


        <?php
        include('includes/scripts.php');
        include('includes/footer.php');
        ?>

            <!--  <td>
        Edit Pop Up Modal
        <div class="modal fade" id="edit_studentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Student Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="manage-students-function.php" method="POST">


                        <div class="modal-body">

                            <input type="hidden" name="edit_ID" id="edit_ID">


                            <div class="form-group">
                                <label for="#">Class - Section</label>
                                <select name="class_id" class="form-control" required>
                                    <option value="" disabled selected>Select Class</option>
                                    <?php
                                    $query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_name");
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="#">Learner Reference Number (LRN)</label>
                                <input type="text" class="form-control" id="edit_lrn" name="lrn" maxlength="13" minlength="13" placeholder="Enter 12-Digit LRN" oninput="formatStudentNumber(this)" required>
                            </div>

                            <div class="form-group">
                                <label for="#">First Name</label>
                                <input type="text" class="form-control" name="firstname" id="edit_firstname" placeholder="Enter First Name" required>
                            </div>

                            <div class="form-group">
                                <label for="#">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="edit_lastname" placeholder="Enter Last Name" required>
                            </div>

                            <div class="form-group">
                                <label for="#">Email</label>
                                <input type="email" class="form-control" name="email" id="edit_email" placeholder="Enter email" required>
                            </div>


                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="text" class="form-control flatpickr" name="dob" id="edit_dob" required placeholder="Enter Date of Birth">
                            </div>


                        </div>
                                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="edit_student" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>  

        <button type="button" class="btn btn-success edit_btn" data-toggle="modal" data-target="#edit_studentModal">Edit</button>
    </td>-->