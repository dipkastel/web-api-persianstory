<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

?>



<div class="container">
		<div class="bodyBox">

			<div class="titleBox">
				<span>مدیریت سایت » مدیریت پست ها » دسته بندی ها</span>
			</div>

			<?php if(validation_errors() != "") { ?>
			<div class="alert alert-danger">
			  <?php echo validation_errors(); ?>
			</div>
			<?php } ?>
			<?php if($sucs != "") { ?>
			<div class="alert alert-success">
			  <?php echo $sucs; ?>
			</div>
			<?php } ?>


				<?php 

				if(isset($_GET['editId'])) 
				echo form_open('tg-admin/addCat/update_cat?editId='.$_GET['editId']);
				else {
				$catval = null;
				echo form_open('tg-admin/addCat/add_cat');
				}
				?>
					<div class="form-group">
						<label for="title"> نام دسته</label>
						<input type="text" class="form-control" id="title" name="name" placeholder="یک دسته وارد کنید" value="<?php echo $catval; ?>">
					</div>
					
					
					
					
					
					
					<div class="form-group pull-left">
					
						<input type="submit" class="btn btn-default btn-customB" style="margin-right:5px;" value="<?php if(isset($_GET['editId'])) echo 'ویرایش'; else echo 'افزودن'; ?>">
					</div>
					
					<div class="clearfix"></div>
				</form>	
				
	<table class="table table-striped">
    <thead>
      <tr>
        <th>آیدی</th>
        <th>نام دسته</th>
        <th>مدیریت</th>
      </tr>
    </thead>
    <tbody>
      
        <?php
        	foreach ($cats as $cat) {
        		echo "<tr><td>".$cat['id']."</td>";
        		echo "<td>".$cat['name']."</td>";
        		echo '<td><a href="'.base_url('tg-admin/addCat/editCat?editId='.$cat['id']).'">ویرایش</a> / <a href="'.base_url('tg-admin/addCat/RemoveCat?id='.$cat['id']).'">حذف</a></td></tr>';
        	}
        ?>
      </tr>
      
    </tbody>
  </table>
  
		</div>
	</div>
