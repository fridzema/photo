require('./bootstrap');

new Dropzone("#dropzone", {
    params: {
      _token: window.Laravel.csrfToken,
    },
    url: '/admin/photos',
    autoProcessQueue: true,
    maxFilesize: 100,
    parallelUploads: 1,
    uploadMultiple: true,
    queuecomplete: function(){
    	location.reload();
    }
});
