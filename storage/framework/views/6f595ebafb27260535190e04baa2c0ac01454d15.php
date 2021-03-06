<?php echo $__env->make('Admin.inc.header source', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="wrapper">
    <?php echo $__env->make('Admin.inc.adminHeader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php echo $__env->make('Admin.inc.adminSideBar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>





        <!-- Main content -->
        <section id="app"  class="content">

            <!--=================== student add modal start here ========================== -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div style="background-color: #00c0ef;" class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add New Student Here</h4>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo e(url('store-student')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label>Select Class:</label>
                                    <select  class="form-control" v-model="classname" @change="StudentUniqueCheck" name="semester">
                                        <option selected disabled>==========SELECT CLASS============</option>
                                        <?php $__currentLoopData = App\semesterlist::orderBy('id', 'DESC')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cat->id); ?>"> Class <?php echo e($cat->semestername); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Student Name:</label>
                                    <input type="text"  name="name" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="roll">Roll:</label>
                                    <input  name="roll" type="int" v-model="rollno" v-on:keyup="StudentUniqueCheck" class="form-control" id="roll">
                                </div>
                                <button style="border-radius:0px;" type="submit" :disabled="disabled == 1" class="btn btn-success"><i class="fa fa-plus"></i> Add Stuent</button>
                                {{studentexisting}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--=================== student add modal end here ============================ -->
            
            <?php if(count($errors)>0): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo e($error); ?>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            
            <?php if(Session::has('message')): ?>
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo e(Session::get('message')); ?>

            </div>
            <?php endif; ?>
            
            
            
            <a data-toggle="modal" data-target="#myModal" style="border-radius:0px;margin-bottom: 10px;" class="btn btn-success pull-right">Add Student &nbsp;<i class="fa fa-plus"></i></a>
            
                <table id="studenttable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Roll</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $studentlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($student->name); ?></td>
                            <td><?php echo e($student->classname->semestername); ?></td>
                            <td><?php echo e($student->roll); ?></td>
                            <td>
                                <a style="border-radius:0px;" href="<?php echo e(url('edit-student',[$student->id])); ?>" class="btn btn-primary">Edit</a>
                                <a style="border-radius:0px;" href="<?php echo e(url('delete-student',[$student->id])); ?>" class="btn btn-danger">Delete</a>
                                <a style="border-radius:0px;" href="<?php echo e(url('add-result',[$student->id])); ?>" class=" btn btn-success">Add Result</a>
                                <a style="border-radius:0px;" href="<?php echo e(url('view-result',[$student->id])); ?>" class="btn-info btn">View Result</a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
        </section>
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.18
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="https://www.facebook.com/forhadreza1596">Md. Forhadul Islam</a>.</strong> All rights
        reserved.
    </footer>

    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php echo $__env->make('Admin.inc.footersource', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
<script>
var csrfToken = '<?php echo e(csrf_token()); ?>';
var adminUrl = '<?php echo e(url('')); ?>';
new Vue({
    el: '#app',
    data: {
        disabled:0,
        studentexisting:null,
        classname:null,
        rollno:null,
        SucessMessage:false,
        returnMessage:"hello world",
        StudentData: [],
        StudentDetails: {name: null, roll: null, semester: null,department:null}
    },

    methods: {
        
        StoreStudent: function (data) {
            if (!confirm('Are you sure'))return;
            data._token = csrfToken;
            this.$http.post('store-student', data)
                .then(function (res) {
                    this.SucessMessage = true;
                    this.returnMessage = res.data.message;
                    this.StudentDetails = {};
                    $('#myModal').modal('hide');
                    location.reload();
           });
        },
        EditStudent: function (data) {
            $('#myModal').modal();
            this.StudentDetails = data;
        },
        StudentUniqueCheck:function(){
            if(this.rollno !=='' && this.classname !==''){
            this.$http.get('unique-student',{params:{class:this.classname,roll:this.rollno}})
            .then(function (res) {
                if(res.data.message==1){
                    this.studentexisting = "Already Have This Student !!!!!";
                    this.disabled = 1;
                }
                else{
                    this.studentexisting = null;
                    this.disabled = 0;
                }
           }); 
            }
          }
        
    }
});

$(document).ready(function () {
    $('#studenttable').DataTable();
});

</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\schoolmanagement\resources\views/Admin/student-manage.blade.php ENDPATH**/ ?>