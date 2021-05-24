require("./bootstrap");

require("alpinejs");
require("dropzone/dist/dropzone.css");
const Dropzone = require("dropzone");

Dropzone.autoDiscover = false;

const thumbnailDropzone = new Dropzone("#products-upload-thumbnail");
