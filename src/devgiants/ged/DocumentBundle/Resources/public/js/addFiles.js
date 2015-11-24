function escapeTags( str ) {
    return String( str )
        .replace( /&/g, '&amp;' )
        .replace( /"/g, '&quot;' )
        .replace( /'/g, '&#39;' )
        .replace( /</g, '&lt;' )
        .replace( />/g, '&gt;' );
}
window.onload = function() {
    var btn = document.getElementById('uploadBtn'),
        progressBar = document.getElementById('progressBar'),
        progressOuter = document.getElementById('progressOuter'),
        msgBox = document.getElementById('msgBox');
        loaderImg = document.getElementById('loaderImg');

    var uploader = new ss.SimpleUpload({
        button: btn,
        url: '/document/upload/', // server side handler
        sessionProgressUrl: '/document/progress/', // enables cross-browser progress support (more info below)
        responseType: 'json',
        name: 'fileName',
        multiple: true,
        multipart: true,
        queue: false,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'pdf', 'zip'], // for example, if we were uploading pics
        hoverClass: 'ui-state-hover',
        focusClass: 'ui-state-focus',
        disabledClass: 'ui-state-disabled',
        debug: true,
        onSubmit: function(filename, extension) {
            // Create the elements of our progress bar
            var progress = document.createElement('div'), // container for progress bar
                bar = document.createElement('div'), // actual progress bar
                fileSize = document.createElement('div'), // container for upload file size
                wrapper = document.createElement('div'), // container for this progress bar
                progressBox = document.getElementById('progressBox'); // on page container for progress bars

            // Assign each element its corresponding class
            progress.className = 'progress';
            bar.className = 'bar';
            fileSize.className = 'size';
            wrapper.className = 'wrapper';

            // Assemble the progress bar and add it to the page
            progress.appendChild(bar);
            wrapper.innerHTML = '<div class="name">'+filename+'</div>'; // filename is passed to onSubmit()
            wrapper.appendChild(fileSize);
            wrapper.appendChild(progress);
            progressBox.appendChild(wrapper); // just an element on the page to hold the progress bars

            // Assign roles to the elements of the progress bar
            this.setProgressBar(bar); // will serve as the actual progress bar
            this.setFileSizeBox(fileSize); // display file size beside progress bar
            this.setProgressContainer(wrapper); // designate the containing div to be removed after upload
        },

        // Do something after finishing the upload
        // Note that the progress bar will be automatically removed upon completion because everything
        // is encased in the "wrapper", which was designated to be removed with setProgressContainer()
        onComplete:   function(filename, response) {
            if (!response) {
                alert(filename + 'upload failed');
                return false;
            }
            // Stuff to do after finishing an upload...
        },
    });
};