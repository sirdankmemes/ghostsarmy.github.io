var image = new Array ();
image[0] = "assets/images/avatar-1.png";
image[1] = "assets/images/avatar-2.png";
image[2] = "assets/images/avatar-3.png";
image[3] = "assets/images/avatar-4.png";
image[4] = "assets/images/avatar-5.png";
image[5] = "assets/images/avatar-6.png";
image[6] = "assets/images/avatar-7.png";
image[7] = "assets/images/avatar-8.png";
var size = image.length
var x = Math.floor(size*Math.random())

$('#image').attr('src',image[x]);