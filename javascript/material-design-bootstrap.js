// Drop this file in resources/js/ and put a "import './material-design-bootstrap.js';" into your app.js

// Workaround issue with MDB https://github.com/mdbootstrap/bootstrap-material-design/issues/245
// More info: https://mdbootstrap.com/support/jquery/bscustomfileinput-is-not-defined/
import bsCustomFileInput from 'mdbootstrap-pro/src/js/vendor/free/bs-custom-file-input';

// Import file structure for Material Design Bootstrap
// See https://mdbootstrap.com/support/jquery/latest-version-of-mdb-not-compatible-with-webpack/
// and https://mdbootstrap.com/support/jquery/issue-with-4-9-0-webpack-typescript/ for further info
// Comment out unneeded libraries in order to reduce build size
import 'mdbootstrap-pro/src/js/vendor/free/jquery.easing';
import 'mdbootstrap-pro/src/js/vendor/free/chart';
import 'mdbootstrap-pro/src/js/vendor/free/chartjs-datalabels';
import 'mdbootstrap-pro/src/js/vendor/free/bs-custom-file-input';
import 'mdbootstrap-pro/src/js/vendor/free/enhanced-modals';
import 'mdbootstrap-pro/src/js/vendor/free/velocity';
import 'mdbootstrap-pro/src/js/vendor/free/waves';

import 'mdbootstrap-pro/src/js/free/forms-free';
import 'mdbootstrap-pro/src/js/free/scrolling-navbar';
import 'mdbootstrap-pro/src/js/free/treeview';
import 'mdbootstrap-pro/src/js/free/wow';

import 'mdbootstrap-pro/src/js/vendor/addons/jquery.zmd.hierarchical-display';
import 'mdbootstrap-pro/src/js/vendor/addons/imagesloaded.pkgd.min';
import 'mdbootstrap-pro/src/js/vendor/addons/datatables';
import 'mdbootstrap-pro/src/js/vendor/addons/datatables-select';
import 'mdbootstrap-pro/src/js/vendor/addons/rating';

import 'mdbootstrap-pro/src/js/vendor/pro/jquery.sticky';
import 'mdbootstrap-pro/src/js/vendor/pro/scrollbar';
import 'mdbootstrap-pro/src/js/vendor/pro/scrolling-navbar';
import 'mdbootstrap-pro/src/js/vendor/pro/jarallax';
import 'mdbootstrap-pro/src/js/vendor/pro/jarallax-video';
import 'mdbootstrap-pro/src/js/vendor/pro/lightbox';
import 'mdbootstrap-pro/src/js/vendor/pro/ofi';
import 'mdbootstrap-pro/src/js/vendor/pro/picker';
import 'mdbootstrap-pro/src/js/vendor/pro/picker-date';
import 'mdbootstrap-pro/src/js/vendor/pro/picker-time';
import 'mdbootstrap-pro/src/js/vendor/pro/picker-date-time';
import 'mdbootstrap-pro/src/js/vendor/pro/toastr';
import 'mdbootstrap-pro/src/js/vendor/pro/vector-map';
import 'mdbootstrap-pro/src/js/vendor/pro/vector-map-world-mill';

import 'mdbootstrap-pro/src/js/vendor/addons-pro/chat';
import 'mdbootstrap-pro/src/js/vendor/addons-pro/multi-range';
import 'mdbootstrap-pro/src/js/vendor/addons-pro/simple-charts';
import 'mdbootstrap-pro/src/js/vendor/addons-pro/steppers';
import 'mdbootstrap-pro/src/js/vendor/addons-pro/timeline';

import 'mdbootstrap-pro/src/js/pro/mdb-autocomplete';
import 'mdbootstrap-pro/src/js/pro/picker-time';
import 'mdbootstrap-pro/src/js/pro/buttons';
import 'mdbootstrap-pro/src/js/pro/cards';
import 'mdbootstrap-pro/src/js/pro/character-counter';
import 'mdbootstrap-pro/src/js/pro/chips';
import 'mdbootstrap-pro/src/js/pro/collapsible';
import 'mdbootstrap-pro/src/js/pro/file-input';
import 'mdbootstrap-pro/src/js/pro/preloading';
import 'mdbootstrap-pro/src/js/pro/range-input';
import 'mdbootstrap-pro/src/js/pro/sidenav';
import 'mdbootstrap-pro/src/js/pro/smooth-scroll';
import 'mdbootstrap-pro/src/js/pro/sticky';
import 'mdbootstrap-pro/src/js/pro/dropdown/dropdown';
import 'mdbootstrap-pro/src/js/pro/dropdown/dropdown-searchable';
import 'mdbootstrap-pro/src/js/pro/material-select/material-select';
import 'mdbootstrap-pro/src/js/pro/material-select/material-select-view';
import 'mdbootstrap-pro/src/js/pro/material-select/material-select-view-renderer';

window.bsCustomFileInput = bsCustomFileInput; // Workaround
