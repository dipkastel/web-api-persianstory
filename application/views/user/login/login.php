<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container" style="width:345px;margin-right:auto;margin-left:auto;padding:0;margin-top:20px;">

<?php
		
		 if (validation_errors()) : ?>
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
			</div>
		<?php endif; ?>
		<?php if (isset($error) && $error !== "") : ?>
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
			</div>
		<?php endif; ?>
		<div class="bodyBox" style="width:345px;margin-right:auto;margin-left:auto;">
		
			<div class="titleBox">
				<span>فرم ورود به حساب کاربری مدیر</span>
			</div>
				<?= form_open() ?>
					<div class="form-group">
						<label for="username"><span class="glyphicon glyphicon-user"></span> نام کاربری</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="نام کاربری">
					</div>
					<div class="form-group">
						<label for="password"><span class="glyphicon glyphicon-lock"></span> رمز عبور</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="رمز عبور">
					</div>
					<div class="form-group">
					<?php echo $widget;?>
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-default btn-customB" value="ورود" style="width:100%;">
					</div>
					<div class="clearfix"></div>
				</form>	
		</div>
	</div>
	<?php echo $script;?>


