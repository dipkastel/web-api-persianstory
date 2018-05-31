<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$dataForm = array();
$dataForm = null;

?>


<div class="container">
		<div class="bodyBox">
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
			<div class="titleBox">
				<span>مدیریت سایت » مدیریت پست ها » افزودن</span>
			</div>
				
				<?php 
				if(isset($_GET['editPostId'])) {
					$dataForm = array();
					$dataForm['name'] = $name;
					$dataForm['teller'] = $teller;
					$dataForm['kholase'] = $kholase;
					$dataForm['matn'] = $matn;
					$dataForm['catval'] = $catval;
					$dataForm['pic'] = $pic;
					$dataForm['sound'] = $sound;
					$dataForm['price'] = $price;
					// $dataForm['pic'] = $pic;
					// $dataForm['music'] = $music;
					echo '<form id="fileupload" action="'.base_url('tg-admin/addPost/updatePost?editPostId='.$_GET['editPostId']).'" method="POST" enctype="multipart/form-data" data-ng-app="demo" data-ng-controller="DemoFileUploadController" data-file-upload="options" data-ng-class="{\'fileupload-processing\': processing() || loadingFiles}" >';
				
			}
				else 
					echo '<form id="fileupload" action="'.base_url('tg-admin/addPost/add_post').'" method="POST" enctype="multipart/form-data" data-ng-app="demo" data-ng-controller="DemoFileUploadController" data-file-upload="options" data-ng-class="{\'fileupload-processing\': processing() || loadingFiles}" >';
				
				?>
					<div class="form-group">
						<label for="name"> نام پست</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="یک نام حداکثر 30 کارکتر" value="<?php if(isset($name)) echo $dataForm['name']; elseif(isset($_POST['name'])) echo $_POST['name']; ?>">
					</div>
					<div class="form-group">
						<label for="teller">نام قصه گو</label>
						<input type="text" class="form-control" id="teller" name="teller" placeholder="" value="<?php if(isset($teller)) echo $dataForm['teller']; elseif(isset($_POST['teller'])) echo $_POST['teller']; ?>">
					</div>
					<div class="form-group">
						<label for="cats">دسته بندی</label>
						<select class="form-control" id="cats" name="cat">
							<?php
							if(!isset($catval)) {
								$catval = 0;
							}
        	foreach ($cats as $cat) {
        		if($catval == $cat['id'])
        		echo '<option value="'.$cat['id'].'" selected>'.$cat['name']."</option>";
        		else
        		echo '<option value="'.$cat['id'].'">'.$cat['name']."</option>";
        		
        	
        }
        ?>
						</select>
					</div>

					


					<div class="form-group">
						<label for="description">خلاصه قصه</label>
						<textarea class="form-control" id="kholase" name="kholase"><?php if(isset($kholase)) echo $dataForm['kholase']; elseif(isset($_POST['kholase'])) echo $_POST['kholase']; ?></textarea>
					</div>

					
					
					
					<div class="row fileupload-buttonbar">
            <div class="col-lg-12">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button" style="width:100%;"	ng-class="{disabled: disabled}">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>افزودن تصویر و صدا</span>
                    <input type="file" name="files[]" ng-disabled="disabled" multiple>
                </span>
                <span class="fileupload-process"></span>
            </div>
			<div class="col-lg-12">
			<center>
				<img src="<?php if(isset($pic)) echo $this->config->item('upload_url').$dataForm['pic']; else echo base_url('assets/images/empty.png');?>" style="border:1px solid #0099FF;margin:5px 0 10px 0;" id="imgselect" width="100" height="100">
				<audio src="<?php if(isset($sound)) echo $this->config->item('upload_url').$dataForm['sound']; else echo '';?>" controls="" id="musicselect" style="width:100%;"></audio>
			</center>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-12 fade" data-ng-class="{in: active()}">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" data-file-upload-progress="progress()"><div class="progress-bar progress-bar-success" data-ng-style="{width: num + '%'}"></div></div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
			
        </div>
		
					
					<table class="table table-striped files ng-cloak">
            <tr data-ng-repeat="file in queue" data-ng-class="{'processing': file.$processing()}">
                <td data-ng-switch data-on="!!file.thumbnailUrl">
                    <div class="preview" data-ng-switch-when="true">
                        <a data-ng-href="{{file.url}}" title="{{file.name}}" download="{{file.name}}" data-gallery><img data-ng-src="{{file.thumbnailUrl}}" alt=""></a>
                    </div>
                    <div class="preview" data-ng-switch-default data-file-upload-preview="file"></div>
                </td>
                <td>
                    <p class="name" data-ng-switch data-on="!!file.url">
                        <span data-ng-switch-when="true" data-ng-switch data-on="!!file.thumbnailUrl">
                            <a data-ng-switch-when="true" data-ng-href="{{file.url}}" title="{{file.name}}" download="{{file.name}}" data-gallery>{{file.name}}</a>
                            <a data-ng-switch-default data-ng-href="{{file.url}}" title="{{file.name}}" download="{{file.name}}">{{file.name}}</a>
                        </span>
                        <span data-ng-switch-default>{{file.name}}</span>
                    </p>
                    <strong data-ng-show="file.error" class="error text-danger">{{file.error}}</strong>
                </td>
                <td>
                    <p class="size">{{file.size | formatFileSize}}</p>
                    <div class="progress progress-striped active fade" data-ng-class="{pending: 'in'}[file.$state()]" data-file-upload-progress="file.$progress()"><div class="progress-bar progress-bar-success" data-ng-style="{width: num + '%'}"></div></div>
                </td>
                <td>
                    <button type="button" class="btn btn-primary start" data-ng-click="file.$submit()" data-ng-hide="!file.$submit || options.autoUpload" data-ng-disabled="file.$state() == 'pending' || file.$state() == 'rejected'">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>شروع بارگذاری</span>
                    </button>
                    <button type="button" class="btn btn-warning cancel" data-ng-click="file.$cancel()" data-ng-hide="!file.$cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>انصراف</span>
                    </button>
                    <button data-ng-controller="FileDestroyController" type="button" class="btn btn-danger destroy" data-ng-click="file.$destroy()" data-ng-hide="!file.$destroy">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>حذف</span>
                    </button>
					 <button data-ng-controller="FileDestroyController" data-ng-click="file.$copyy()" type="button" class="btn btn-success selectpic pendc">
                        
                        <span>انتخاب تصویر</span>
                    </button>
                </td>
            </tr>
        </table>
					  
					<input type="hidden" name="imgname" id="imgname" value="<?php if(isset($pic)) echo $dataForm['pic']; ?>" />
					<input type="hidden" name="musicname" id="musicname" value="<?php if(isset($sound)) echo $dataForm['sound']; ?>" />
					<div class="form-group">
						<label for="price">قیمت پست</label>
						<input type="text" class="form-control" id="price" name="price" placeholder="در صوت خالی بودن رایگان محسوب میشود" value="<?php if(isset($price)) echo $dataForm['price']; ?>">
					</div>
					<div class="form-group pull-left">
						<input type="submit" class="btn btn-default btn-customB" name="save" style="margin-right:5px;" value="انتشار">
					</div>
					<div class="form-group pull-left">
						<input type="submit" class="btn btn-default" name="pending" value="ذخیره در پیش نویس">
					</div>
					<div class="clearfix"></div>
				</form>	
		</div>
	</div>

<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>


<script>
CKEDITOR.replace( 'editor1', {
  extraPlugins: 'imageuploader'
});
</script>
	