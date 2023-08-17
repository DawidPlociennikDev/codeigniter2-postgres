<?php $this->view('back/blocks/head.php'); ?>
<?php $this->view('back/blocks/header.php'); ?>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sign Up Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <form method="post" action="" class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="index.html" class="">
                            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DawidPanel</h3>
                        </a>
                        <h3>Sign Up</h3>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="first_name" type="text" class="form-control" id="floatingText" placeholder="name" value="<?= set_value('first_name'); ?>">
                        <label for="floatingText">First name</label>
                        <div class="invalid-feedback"><?php echo form_error('first_name'); ?></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="last_name" type="text" class="form-control" id="floatingText" placeholder="last name" value="<?= set_value('last_name'); ?>">
                        <label for="floatingText">Last name</label>
                        <div class="invalid-feedback"><?php echo form_error('last_name'); ?></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input name="email" type="email" class="form-control" id="floatingInput" placeholder="email" value="<?= set_value('email'); ?>">
                        <label for="floatingInput">Email address</label>
                        <div class="invalid-feedback"><?php echo form_error('email'); ?></div>
                    </div>
                    <div class="form-floating mb-4">
                        <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="password">
                        <label for="floatingPassword">Password</label>
                        <div class="invalid-feedback"><?php echo form_error('password'); ?></div>
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                    <p class="text-center mb-0">Already have an Account? <a href="<?= base_url('logowanie') ?>">Sign In</a></p>
                </form>
            </div>
        </div>
    </div>
    <!-- Sign Up End -->
</div>
<?php $this->view('back/blocks/footer.php'); ?>