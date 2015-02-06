
	<div class="signup_form_div  col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-xs-12" >
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
					<input type="submit" value="Sign Up" name="SignUp" class="app_btn" disabled="disabled"/>
				</div>
				
			</form>
	</div>

