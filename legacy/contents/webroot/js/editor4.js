tinymce.init({
	selector: 'textarea.ckeditor',
	language: 'es',
	convert_urls: false,
	plugins: 'paste table link fullscreen code',
	statusbar: false,
	toolbar: "undo redo | link unlink | table | bold italic subscript superscript | styleselect | numlist bullist | alignleft aligncenter alignright alignjustify | code fullscreen",
	menubar: false,
	valid_elements: 'a[href|target],p[align],br,strong/b,h1,h2,h3,h4,h5,h6,table,thead,tbody,th,td,tr,ul,li,ol,blockquote,em/i,strike,u,sup,sub',
});
