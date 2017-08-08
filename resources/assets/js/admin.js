/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var photoPlaceholder = document.getElementById("photos");

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
    	InitiatePhotoGrid();
    }
});

function InitiatePhotoGrid(){
	axios.get('/photo_feed')
	.then(function (photos) {
    var template = '{{#photos}}<a><figure><img src="{{url}}" /></figure></a>{{/photos}}';
    Mustache.parse(template);
    photoPlaceholder.innerHTML = Mustache.render(template, photos.data);
	});
}

InitiatePhotoGrid();