/*
 * jQuery File Upload Plugin Angular JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* jshint nomen:false */
/* global window, angular */

;(function () {
	var siteurl = "//bahar.persianstory.ir/ghesegoo/"
    'use strict';

    var isOnGitHub = window.location.hostname === '//localhost:8027/uploader/',
        url = isOnGitHub ? '//localhost:8027/uploader/' : '//localhost:8027/uploader/';

    angular.module('demo', [
        'blueimp.fileupload'
    ])
        .config([
            '$httpProvider', 'fileUploadProvider',
            function ($httpProvider, fileUploadProvider) {
                delete $httpProvider.defaults.headers.common['X-Requested-With'];
                fileUploadProvider.defaults.redirect = window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                );
                if (isOnGitHub) {
                    // Demo settings:
                    angular.extend(fileUploadProvider.defaults, {
                        // Enable image resizing, except for Android and Opera,
                        // which actually support image resizing, but fail to
                        // send Blob objects via XHR requests:
                        disableImageResize: /Android(?!.*Chrome)|Opera/
                            .test(window.navigator.userAgent),
                        maxFileSize: 20000000,
                        acceptFileTypes: /(\.|\/)(jpe?g|png|mp3)$/i
                    });
                }
            }
        ])

        .controller('DemoFileUploadController', [
            '$scope', '$http', '$filter', '$window',
            function ($scope, $http) {
                $scope.options = {
                    url: url+"index.php?postid=2"
                };
                if (!isOnGitHub) {
                    $scope.loadingFiles = true;
                    $http.get(url+"index.php?postid=2")
                        .then(
                            function (response) {
                                $scope.loadingFiles = false;
                                $scope.queue = response.data.files || [];
                            },
                            function () {
                                $scope.loadingFiles = false;
                            }
                        );
                }
            }
        ])

        .controller('FileDestroyController', [
            '$scope', '$http',
            function ($scope, $http) {
                var file = $scope.file,
                    state;
                if (file.url) {
                    file.$state = function () {
                        return state;
                    };
                    file.$destroy = function () {
                        state = 'pending';
                        return $http({
                            url: file.deleteUrl,
                            method: file.deleteType
                        }).then(
                            function () {
                                state = 'resolved';
                                $scope.clear(file);
								if(file.url == $('#musicselect').attr('src')) {
								$('#musicselect').attr('src', "");
								$('#musicname').val("");
								}
								if(file.url == $('#imgselect').attr('src')) {
								$('#imgselect').attr('src', siteurl+"images/empty.png");
								$('#imgname').val("");
								}
                            },
                            function () {
                                state = 'rejected';
                            }
                        );
                    };
					var filetypee = "null";
					if(file.type == "audio/mpeg" || file.type == "audio/mp3" || file.type == "audio" || file.type == "mp3" || file.type == "application/octet-stream")
						filetypee = "صدا";
					else
						filetypee = "تصویر";
					$('.pendc').html("<i class=\"glyphicon glyphicon-ok\"></i> انتخاب " + filetypee);
					$('.selectpic').addClass("okc");
					
					$('.selectpic').removeClass("pendc");
					$('.selectpic').show();
					 file.$copyy = function () { 
                       if(file.type == "audio/mpeg" || file.type == "audio/mp3" || file.type == "application/octet-stream") {
						   $('#musicname').val(file.name);
						   $('#musicselect').attr('src', file.url);
					   } else {
						   $('#imgname').val(file.name);
						   $('#imgselect').attr('src', file.url);
					   }
						

						return false 

                    };
					
					
					
					
					
                } else if (!file.$cancel && !file._index) {
                    file.$cancel = function () {
                        $scope.clear(file);
                    };
                }
            }
        ]);
		
		
		
		
		

}());
