<div class="container sign_pick" >
	<div class="sign_form_div">
			<form method="post" action="<?php echo base_url('signup');?>">
				<div class="form-group">
					
					Fullname<input type="text" name="full_name" id="full_name" placeholder="eg. Kofi Attah" required="required" class="form-control" />
				</div>
				<div class="form-group">
					
					Username<input type="text" name="username" id="username" placeholder="eg. k_Attah" required="required" class="form-control" />
				</div>
				<div class="form-group">
					
					Email<input type="email" name="email" id="email" placeholder="eg. k_Attah@me.com" required="required" class="form-control" />
				</div>
				<div class="form-group">
					
					Password<input type="password" name="password" id="password" required="required" class="form-control" />
				</div>
				<div class="form-group">
					
					Confirm Password<input type="password" name="c_password" id="c_password" required="required" class="form-control" />
				</div>
				<div class="form-group">
					<input type="submit" value="Sign Up"  class="app_btn" />
				</div>
	
			</form>
	</div>
</div>
