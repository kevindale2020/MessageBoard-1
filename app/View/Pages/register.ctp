<!-- <div class="container mt-3">
  <div class="col-md-4">
  <h2>Registration</h2>
  <?php echo $this->Form->create(); ?>
    <div class="mb-3 mt-3">
      <?php echo $this->Form->input('name:', array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name', 'name' => 'name')); ?>
    </div>
    <div class="mb-3">
      <?php echo $this->Form->input('email address:', array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter email address', 'name' => 'email', 'type' => 'email')); ?>
    </div>
     <div class="mb-3">
      <?php echo $this->Form->input('password:', array('class' => 'form-control', 'id' => 'pass', 'placeholder' => 'Enter password', 'name' => 'password')); ?>
    </div>
    <div class="mb-3">
      <?php echo $this->Form->input('confirm password:', array('class' => 'form-control', 'id' => 'pass2', 'placeholder' => 'Confirm password')); ?>
    </div>
    <?php echo $this->Form->submit('Register', array('class' => 'btn btn-primary'));?>
  <?php echo $this->Form->end(); ?>
</div>
</div>
 -->


<div class="container mt-3">
  <div class="col-md-4">
  <h2>Registration</h2>
  <form id="registerForm">
    <div class="mb-3 mt-3">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
    </div>
    <div class="mb-3">
      <label for="email">Email Address:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
     <div class="mb-3">
      <label for="pass1">Password:</label>
      <input type="password" class="form-control" id="pass1" placeholder="Enter password" name="password">
    </div>
    <div class="mb-3">
      <label for="pass2">Confirm Password:</label>
      <input type="password" class="form-control" id="pass2" placeholder="Confirm password">
    </div>
    <button class="btn btn-primary" id="btnRegister" name="btnRegister">Submit</button>
  </form>
</div>
</div>
