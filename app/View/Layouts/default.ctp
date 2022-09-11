<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->meta('myToken', $this->request->param('csrfToken'));

		echo $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css');

		echo $this->Html->css('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

		echo $this->Html->css('mb.css');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <span class="navbar-brand text-color">Message Board</span>

  <div class="navbar-nav">
  	<?php if($logged_in): ?>
    	<?php echo $this->Html->link('Home', '/home', array('class' => 'nav-item nav-link'));?>
	<?php else: ?>
		<?php echo $this->Html->link('Home', '/', array('class' => 'nav-item nav-link'));?>
	<?php endif; ?>
    <?php echo $this->Html->link('About', '', array('class' => 'nav-item nav-link'));?>
    <?php echo $this->Html->link('Contact', '', array('class' => 'nav-item nav-link'));?>
  </div>

  <div class="navbar-nav ml-auto">
  	<?php if($logged_in): ?>
  	<!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        <?php echo $user[0]['Users']['email']; ?>
      </a>
      <div class="dropdown-menu">
      	<?php echo $this->Html->link('Profile', '/home/profile', array('class' => 'dropdown-item'));?>
        <?php echo $this->Html->link('Logout', '/logout', array('class' => 'dropdown-item'));?>
      </div>
    </li>
  	<?php else: ?>
  		<?php echo $this->Html->link('Register', '/register', array('class' => 'nav-item nav-link'));?>
    	<?php echo $this->Html->link('Login', '/login', array('class' => 'nav-item nav-link'));?>
	  <?php endif; ?>
  </div>
</nav>
	<div class="container">
		<?php echo $this->Flash->render(); ?>
		<?php echo $this->fetch('content'); ?>
	</div>
<?php echo $this->element('sql_dump'); ?> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- 	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="myToken"]').attr('content')
            }
        });
    </script>
	<script type="text/javascript">
		$(document).ready(function(){

			var counter = 5;
			var counterComments = 5;

			$('#btnShowMore').hide();
			$('#btnShowMore2').hide();

			<?php if($logged_in): ?>
				getProfile();
				getRecipients();
				getMessageLists();

				<?php if(isset($message['Messages']['id'])): ?>
					getComments();
				<?php endif;?>
			<?php endif;?>
			
			$('#registerForm').submit(function(e){

				e.preventDefault();

				var name = $('#name').val();
	            var email = $('#email').val();
	            var pass1 = $('#pass1').val();
	            var pass2 = $('#pass2').val();

	            var message = "";

	            if(name==''||email==''||pass1=='') {

	                if(name=='') {

	                    message += "Name is required\n";
	                }

	                if(email=='') {

	                    message += "Email is required\n";
	                }

	                if(pass1=='') {

	                    message += "Password is required\n";
	                }

	                if(pass2=='') {

	                		message += "Confirm password is required\n";
	                }

	                alert(message);

	                return false;
	            }

	            if(pass1 != pass2) {

	                message += "Password does not match";

	                alert(message);

	                return false;
	            }

	            if(pass1.length < 8) {

	                message += "Password should at least be 8 characters";

	                alert(message);

	                return false;
	            }

	            $.ajax({

	                url: '<?php echo $this->Html->url('/register');?>',
	                method: 'POST',
	                data: new FormData(this),
	                contentType: false,
	                processData: false,
	                success: function(data) {
	                   
	                    var data = JSON.parse(data);

	                   	if(data.success==1) {
	                   		alert(data.message);
	                   		$('#registerForm')[0].reset();
	                   		window.location.href='<?php echo $this->Html->url('/thankyou');?>';
	                   	} else {
	                   		alert(data.messageErr);
	                   	}
	                },
	                error: function(jqXHR, status, error) {
	                  console.log(status);
	                  console.log(error);
	                }
	            });
			});

			$('#loginForm').submit(function(e){

				e.preventDefault();

	            var email = $('#email').val();
	            var password = $('#password').val();

	            var message = "";

	            if(email==''||password=='') {

	                if(name=='') {

	                    message += "Email is required\n";
	                }

	                if(password=='') {

	                    message += "Password is required\n";
	                }

	                alert(message);

	                return false;
	           	}

	            $.ajax({

	                url: '<?php echo $this->Html->url('/login');?>',
	                method: 'POST',
	                data: new FormData(this),
	                contentType: false,
	                processData: false,
	                success: function(data) {
	                   
	                    var data = JSON.parse(data);

	                    // console.log(data);

	                   	if(data.success==1) {
	                   		window.location.href='<?php echo $this->Html->url('/home');?>';
	                   	} else {
	                   		alert(data.message);
	                   	}
	                },
	                error: function(jqXHR, status, error) {
	                  console.log(status);
	                  console.log(error);
	                }
	            });
			});

			$('#profileForm').submit(function(e){

				e.preventDefault();

				var extension = $('#image').val().split('.').pop().toLowerCase();
				var image = $('#image').val();
				var name = $('#ep_name').val();
				var email = $('#ep_email').val();
				var bdate =	$('#ep_bdate').val();
				var hobby = $('#ep_hobby').val();

	            var message = "";

	            if(name==''||email==''||bdate==''||hobby=='') {

	                if(name=='') {

	                    message += "Name is required\n";
	                }

	                if(email=='') {

	                    message += "Email is required\n";
	                }

	                if(bdate=='') {

	                	message += "Birthdate is required\n";
	                }

	                if(hobby=='') {

	                	message += "Hobby is required\n";
	                }

	                alert(message);

	                return false;
	           	}

	           	if(image!='') {
	                if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
	                    alert('Invalid File');
	                    return false;
	                }
            	}

	            $.ajax({

	                url: '<?php echo $this->Html->url('/home/editprofile');?>',
	                method: 'POST',
	                data: new FormData(this),
	                contentType: false,
	                processData: false,
	                success: function(data) {
	                   
	                    var data = JSON.parse(data);

	                    if(data.success==1) {

	                    	alert(data.message);

	                    	$('#profileForm')[0].reset();

	                    	$('#profileModal').modal('hide');

	                    	getProfile();
	                    }
	                },
	                error: function(jqXHR, status, error) {
	                  console.log(status);
	                  console.log(error);
	                }
	            });
			});

			$('#btnNew').click(function(){

				$('#messageModal').modal('show');
			});

			$('#messageForm').submit(function(e){

				e.preventDefault();

				var recipient = $('#recipient').val();
				var title = $('#title').val();
				var body =	$('#body').val();

	            var message = "";

	            if(recipient==''||title==''||body=='') {

	                if(recipient=='') {

	                    message += "Recipient is required\n";
	                }

	                if(title=='') {

	                    message += "Title is required\n";
	                }

	                if(body=='') {

	                	message += "Body is required\n";
	                }

	                alert(message);

	                return false;
	           	}

	            $.ajax({

	                url: '<?php echo $this->Html->url('/home/newmessage');?>',
	                method: 'POST',
	                data: new FormData(this),
	                contentType: false,
	                processData: false,
	                success: function(data) {
	                   
	                    var data = JSON.parse(data);

	                    if(data.success==1) {

	                    	alert(data.message);

	                    	$('#messageForm')[0].reset();

	                    	$('#messageModal').modal('hide');

	                    	getRecipients();

	                    	$('#recipient').select2({

													templateResult: recipientStyles,
													dropdownParent: $('#messageModal')
												});

	                    	getMessageLists();

	                    }
	                },
	                error: function(jqXHR, status, error) {
	                  console.log(status);
	                  console.log(error);
	                }
	            });
			});


			function recipientStyles (selection) {
			  if (!selection.id) { return selection.text; }
		    var thumb = $(selection.element).data('thumb');
		    if(!thumb){
		      return selection.text;
		    } else {
		      var $selection = $(
		    '<span><img src="<?php echo $this->webroot;?>img/' + thumb + '" width="32" height="32" class="img-flag" alt=""><span class="img-changer-text">' + $(selection.element).text() + '</span>'
		  );
  		return $selection;
  		}
		};

		$('#recipient').select2({

			templateResult: recipientStyles,
			dropdownParent: $('#messageModal')
		});

		$('#commentForm').submit(function(e){

			e.preventDefault();

			var content = $('#content').val();

			if(content=='') {
				alert('This is required');
			}

			$.ajax({
				url: '<?php echo $this->Html->url('/home/comment');?>',
				method: 'POST',
				async: false,
				data: new FormData(this),
				contentType: false,
				processData: false,
				success: function(data) {

					var data = JSON.parse(data);

					if(data.success==1) {
						alert(data.message);
						$('#commentForm')[0].reset();
						getComments();
					}

				},
				error: function(jqXHR, error, status) {

					console.log(error);
					console.log(status);
				}
			});
		});

		$('#btnShowMore').click(function(){

			counter = counter + 5;

			$.ajax({

				url: '<?php echo $this->Html->url('/home/getmessagelists2');?>',
				method: 'POST',
				async: false,
				data: {
					messages2: 1,
					counter: counter
				},
				success: function(data) {

					var data = JSON.parse(data);

					data = data['lists'];

					var result = "";

					if(data.length > 0) {

						for(var i=0; i<data.length; i++) {

							result+="<h2 class='mt-3'><a class='text-body' href='<?php echo $this->Html->url('/home/details/');?>"+data[i]['Messages']['id']+"'>"+data[i]['Messages']['title']+"</a></h2>";
							result+="<span class='text text-danger pull-right delete_message' id="+data[i]['Messages']['id']+"><i class='fa fa-trash-o' aria-hidden='true'></i></span>";
							result+="<h5><i class='fa fa-clock-o' aria-hidden='true'></i> Posted by "+data[i]['Users']['name']+", "+moment(data[i]['Messages']['posted']).format('MMMM Do YYYY, h:mm a')+"</h5>";
							result+=" <h5><span class='badge badge-dark'>"+data[i]['Recipients']['name']+"</span></h5><br>";
							result+="<p>"+data[i]['Messages']['body']+"</p>";

						}
					} else {

						result+="<p class='text-muted'>No messages</p>";
					}

					$('#messages').html(result);

					
				}
			});
		});

		$('#btnShowMore2').click(function(){

			counterComments = counterComments + 5;

			<?php if(isset($message['Messages']['id'])): ?>

				var id = <?php echo $message['Messages']['id'];?>

				$.ajax({
					url: '<?php echo $this->Html->url('/home/getcomments2');?>',
					method: 'POST',
					async: false,
					data: {
						id: id,
						counterComments: counterComments
					},
					success: function(data) {

						var data = JSON.parse(data);

						if(data.success==1) {
							$('#comments').html(data['results']);
						}
					}
				});
			<?php endif; ?>
		});

		$('#btnSearch').click(function(){

			var searchStr = $('#searchStr').val();

			if(searchStr=='') {
				alert('This is required');
			}

			$.ajax({
				url: '<?php echo $this->Html->url('/home/searchcmessage');?>',
				method: 'POST',
				async: false,
				data: {
					search: 1,
					searchStr: searchStr
				},
				success: function(data) {

					var data = JSON.parse(data);

					if(data['size'] > 5) {

						$('#btnShowMore').show();
					} else {

						$('#btnShowMore').hide();
					}

					data = data['lists'];

					var result = "";

					if(data.length > 0) {

						for(var i=0; i<data.length; i++) {

							result+="<h2 class='mt-3'><a class='text-body' href='<?php echo $this->Html->url('/home/details/');?>"+data[i]['Messages']['id']+"'>"+data[i]['Messages']['title']+"</a></h2>";
							result+="<span class='text text-danger pull-right delete_message' id="+data[i]['Messages']['id']+"><i class='fa fa-trash-o' aria-hidden='true'></i></span>";
							result+="<h5><i class='fa fa-clock-o' aria-hidden='true'></i> Posted by "+data[i]['Users']['name']+", "+moment(data[i]['Messages']['posted']).format('MMMM Do YYYY, h:mm a')+"</h5>";
							result+=" <h5><span class='badge badge-dark'>"+data[i]['Recipients']['name']+"</span></h5><br>";
							result+="<p>"+data[i]['Messages']['body']+"</p>";

						}
					} else {

						result+="<p class='text-muted'>No results found</p>";
					}

					$('#messages').html(result);
				}
			});

		});

		$(document).on('click', '.delete_message', function(){

			var id = $(this).attr('id');

			
			if(confirm('Are you sure you want to delete this message?')) {

                $.ajax({
                  url: '<?php echo $this->Html->url('/home/delete');?>',
                  method: 'POST',
                  async: false,
                  data: {
                    id: id
                  },
                  success: function(data) {

                  	  var data = JSON.parse(data);
                  	  
                  	  if(data.success==1) {

                  	  	alert(data.message);

                  	  	getMessageLists();
                  	  }
                 }
                });
            } else {
              return false;
       }
		});

            
		});

		function getComments() {

			<?php if(isset($message['Messages']['id'])): ?>

				var id = <?php echo $message['Messages']['id'];?>

				$.ajax({
					url: '<?php echo $this->Html->url('/home/getcomments');?>',
					method: 'POST',
					async: false,
					data: {
						id: id
					},
					success: function(data) {

						var data = JSON.parse(data);

						if(data['size'] > 5) {

						$('#btnShowMore2').show();
						} else {

						$('#btnShowMore2').hide();
						}

						if(data.success==1) {
							$('#comments').html(data['results']);
						}
					}
				});
			<?php endif; ?>


		}

		function getMessageLists() {

			var str = "";
			var newStr= "";

			$.ajax({

				url: '<?php echo $this->Html->url('/home/getmessagelists');?>',
				method: 'POST',
				async: false,
				data: {
					messages: 1
				},
				success: function(data) {

					var data = JSON.parse(data);

					if(data['size'] > 5) {

						$('#btnShowMore').show();
					} else {

						$('#btnShowMore').hide();
					}

					data = data['lists'];

					var result = "";

					if(data.length > 0) {

						for(var i=0; i<data.length; i++) {

							str = data[i]['Messages']['body'];

							if(str.length > 565) {
								newStr = str.substring(0, 565) + '...';
							} else {
								newStr = str;
							}

							result+="<h2 class='mt-3'><a class='text-body' href='<?php echo $this->Html->url('/home/details/');?>"+data[i]['Messages']['id']+"'>"+data[i]['Messages']['title']+"</a></h2>";
								result+="<span class='text text-danger pull-right delete_message' id="+data[i]['Messages']['id']+"><i class='fa fa-trash-o' aria-hidden='true'></i></span>";
							result+="<h5><i class='fa fa-clock-o' aria-hidden='true'></i> Posted by "+data[i]['Users']['name']+", "+moment(data[i]['Messages']['posted']).format('MMMM Do YYYY, h:mm a')+"</h5>";
							result+=" <h5><span class='badge badge-dark'>"+data[i]['Recipients']['name']+"</span></h5><br>";
							result+="<p>"+newStr+"</p>";

						}
					} else {

						result+="<p class='text-muted'>No messages</p>";
					}

					$('#messages').html(result);

					
				}
			});
		}

		function getRecipients() {

			$.ajax({

				url: '<?php echo $this->Html->url('/home/getrecipients');?>',
				method: 'POST',
				async: false,
				data: {
					recipients: 1
				},
				success: function(data) {

					var data = JSON.parse(data);

					if(data.success==1) {

						$('#recipients').html(data['recipients']);
					}
				}
			});
		}

		function getProfile() {

			$.ajax({

				url: '<?php echo $this->Html->url('/home/profile');?>',
				method: 'POST',
				async: false,
				data: {
					profile: 1
				},
				success: function(data) {

					var data = JSON.parse(data);

					data = data['user'];

					if(data['Users']['image']!="") {

						$('#imgProfile').attr('src', '<?php echo $this->webroot;?>img/'+data['Users']['image']);
					} else {

						$('#imgProfile').attr('src', '<?php echo $this->webroot;?>img/user_none.png');
					}
					$('#p_name').html(data['Users']['name']);
					$('#p_email').html(data['Users']['email']);
					if(data['Users']['birthdate']!='0000-00-00') {
						$('#p_bdate').html(moment(data['Users']['birthdate']).format('MMMM DD YYYY'));
					}
					$('#p_gender').html(data['Users']['gender']);
					$('#p_hobby').html(data['Users']['hobby']);
					$('#p_created').html(moment(data['Users']['created']).format('MMMM Do YYYY, h:mm a'));
					$('#p_modified').html(moment(data['Users']['modified']).format('MMMM Do YYYY, h:mm a'));


					$('#ep_name').val(data['Users']['name']);
					$('#ep_email').val(data['Users']['email']);

					if(data['Users']['birthdate']!='0000-00-00') {
						$('#ep_bdate').val(data['Users']['birthdate']);
					}
					$('#ep_hobby').val(data['Users']['hobby']);

					if(data['Users']['gender']!=null) {

						if(data['Users']['gender']=='Male') {

							$('#radio1').prop('checked', true);
						} else {
							$('#radio2').prop('checked', true);
						}
					}
				}
			});
		}

		function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#imgProfile').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }
	</script>
</body>

</html>
