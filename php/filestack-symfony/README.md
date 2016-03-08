Uploader.php
This is a symfony service to help upload the file from filepicker to your server.This is a little service used to upload files from filepicker.  Be this script needs a few things. 
 it needs a temp location to store files (line 30), and a finale place to store files. Line 74 for the root path. this will also need to be registered with your app. something like this: 
     app_bundle.uploader:
        class: AppBundle\Services\Uploader
        arguments: []
 
 UploadController.pgp
 An example controller using the upload service
 
filestack.html.twig
This file will create the javascript required to add an uploader to your form.  Make sure you have a additional, non-mapped button in your form class, and you need to bind that element to some of the events in this class. 

in your template file, you'll want to include the above file with the following parameters
    {% include 'partials/handlebars.html.twig' %}
    {% include 'partials/filestack.html.twig' with
    {
    file_id:'#admin_post_upload_featuredImage',
    hidden_id:'#admin_post_featuredImage',
    upload_location:'/admin-post-images/',
    sub_dir:'uploads/admin-post-images/',
    type:'featuredImage',
    message_shell:'#message-shell'
    }
    %}
	
handlebars.html.twig
This file contains a a partial to display the uploaded photo via filestack, and a little alert message template to display errors. 