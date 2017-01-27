<?php
//============================================================+
// File name   : tcpdf.php
// Version     : 5.9.158
// Begin       : 2002-08-03
// Last Update : 2012-04-22
// Author      : Nicola Asuni - Tecnick.com LTD - Manor Coach House, Church Hill, Aldershot, Hants, GU12 4RQ, UK - www.tecnick.com - info@tecnick.com
// License     : http://www.tecnick.com/pagefiles/tcpdf/LICENSE.TXT GNU-LGPLv3
// -------------------------------------------------------------------
// Copyright (C) 2002-2012 Nicola Asuni - Tecnick.com LTD
//setPrintHeader
// This file is part of TCPDF software library.
//
// TCPDF is free software: you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// TCPDF is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the License
// along with TCPDF. If not, see
// <http://www.tecnick.com/pagefiles/tcpdf/LICENSE.TXT>.

//
// See LICENSE.TXT file for more information.
// -------------------------------------------------------------------
//
// Description :
//   This is a PHP class for generating PDF documents without requiring external extensions.
//
// NOTE:
//   This class was originally derived in 2002 from the Public
//   Domain FPDF class by Olivier Plathey (http://www.fpdf.org),
//   but now is almost entirely rewritten and contains thousands of
//   new lines of code and hundreds new features.
//
// Main features:
//  * no external libraries are required for the basic functions;
//  * all standard page formats, custom page formats, custom margins and units of measure;
//  * UTF-8 Unicode and Right-To-Left languages;
//  * TrueTypeUnicode, TrueType, Type1 and CID-0 fonts;
//  * font subsetting;
//  * methods to publish some XHTML + CSS code, Javascript and Forms;
//  * images, graphic (geometric figures) and transformation methods;
//  * supports JPEG, PNG and SVG images natively, all images supported by GD (GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM) and all images supported via ImagMagick (http://www.imagemagick.org/www/formats.html)
//  * 1D and 2D barcodes: CODE 39, ANSI MH10.8M-1983, USD-3, 3 of 9, CODE 93, USS-93, Standard 2 of 5, Interleaved 2 of 5, CODE 128 A/B/C, 2 and 5 Digits UPC-Based Extention, EAN 8, EAN 13, UPC-A, UPC-E, MSI, POSTNET, PLANET, RMS4CC (Royal Mail 4-state Customer Code), CBC (Customer Bar Code), KIX (Klant index - Customer index), Intelligent Mail Barcode, Onecode, USPS-B-3200, CODABAR, CODE 11, PHARMACODE, PHARMACODE TWO-TRACKS, Datamatrix, QR-Code, PDF417;
//  * JPEG and PNG ICC profiles, Grayscale, RGB, CMYK, Spot Colors and Transparencies;
//  * automatic page header and footer management;
//  * document encryption up to 256 bit and digital signature certifications;
//  * transactions to UNDO commands;
//  * PDF annotations, including links, text and file attachments;
//  * text rendering modes (fill, stroke and clipping);
//  * multiple columns mode;
//  * no-write page regions;
//  * bookmarks, named destinations and table of content;
//  * text hyphenation;
//  * text stretching and spacing (tracking/kerning);
//  * automatic page break, line break and text alignments including justification;
//  * automatic page numbering and page groups;
//  * move and delete pages;
//  * page compression (requires php-zlib extension);
//  * XOBject Templates;
//  * Layers and object visibility.
//	* PDF/A-1b support.
//
// -----------------------------------------------------------
// THANKS TO:
//
// Olivier Plathey (http://www.fpdf.org) for original FPDF.
// Efthimios Mavrogeorgiadis (emavro@yahoo.com) for suggestions on RTL language support.
// Klemen Vodopivec (http://www.fpdf.de/downloads/addons/37/) for Encryption algorithm.
// Warren Sherliker (wsherliker@gmail.com) for better image handling.
// dullus for text Justification.
// Bob Vincent (pillarsdotnet@users.sourceforge.net) for <li> value attribute.
// Patrick Benny for text stretch suggestion on Cell().
// Johannes G?ntert for JavaScript support.
// Denis Van Nuffelen for Dynamic Form.
// Jacek Czekaj for multibyte justification
// Anthony Ferrara for the reintroduction of legacy image methods.
// Sourceforge user 1707880 (hucste) for line-trough mode.
// Larry Stanbery for page groups.
// Martin Hall-May for transparency.
// Aaron C. Spike for Polycurve method.
// Mohamad Ali Golkar, Saleh AlMatrafe, Charles Abbott for Arabic and Persian support.
// Moritz Wagner and Andreas Wurmser for graphic functions.
// Andrew Whitehead for core fonts support.
// Esteban Jo?l Mar?n for OpenType font conversion.
// Teus Hagen for several suggestions and fixes.
// Yukihiro Nakadaira for CID-0 CJK fonts fixes.
// Kosmas Papachristos for some CSS improvements.
// Marcel Partap for some fixes.
// Won Kyu Park for several suggestions, fixes and patches.
// Dominik Dzienia for QR-code support.
// Laurent Minguet for some suggestions.
// Christian Deligant for some suggestions and fixes.
// Travis Harris for crop mark suggestion.
// Anyone that has reported a bug or sent a suggestion.
//============================================================+

/**
 * @file
 * This is a PHP class for generating PDF documents without requiring external extensions.<br>
 * TCPDF project (http://www.tcpdf.org) was originally derived in 2002 from the Public Domain FPDF class by Olivier Plathey (http://www.fpdf.org), but now is almost entirely rewritten.<br>
 * <h3>TCPDF main features are:</h3>
 * <ul>
 * <li>no external libraries are required for the basic functions;</li>
 * <li>all standard page formats, custom page formats, custom margins and units of measure;</li>
 * <li>UTF-8 Unicode and Right-To-Left languages;</li>
 * <li>TrueTypeUnicode, TrueType, Type1 and CID-0 fonts;</li>
 * <li>font subsetting;</li>
 * <li>methods to publish some XHTML + CSS code, Javascript and Forms;</li>
 * <li>images, graphic (geometric figures) and transformation methods;
 * <li>supports JPEG, PNG and SVG images natively, all images supported by GD (GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM) and all images supported via ImagMagick (http://www.imagemagick.org/www/formats.html)</li>
 * <li>1D and 2D barcodes: CODE 39, ANSI MH10.8M-1983, USD-3, 3 of 9, CODE 93, USS-93, Standard 2 of 5, Interleaved 2 of 5, CODE 128 A/B/C, 2 and 5 Digits UPC-Based Extention, EAN 8, EAN 13, UPC-A, UPC-E, MSI, POSTNET, PLANET, RMS4CC (Royal Mail 4-state Customer Code), CBC (Customer Bar Code), KIX (Klant index - Customer index), Intelligent Mail Barcode, Onecode, USPS-B-3200, CODABAR, CODE 11, PHARMACODE, PHARMACODE TWO-TRACKS, Datamatrix, QR-Code, PDF417;</li>
 * <li>JPEG and PNG ICC profiles, Grayscale, RGB, CMYK, Spot Colors and Transparencies;</li>
 * <li>automatic page header and footer management;</li>
 * <li>document encryption up to 256 bit and digital signature certifications;</li>
 * <li>transactions to UNDO commands;</li>
 * <li>PDF annotations, including links, text and file attachments;</li>
 * <li>text rendering modes (fill, stroke and clipping);</li>
 * <li>multiple columns mode;</li>
 * <li>no-write page regions;</li>
 * <li>bookmarks, named destinations and table of content;</li>
 * <li>text hyphenation;</li>
 * <li>text stretching and spacing (tracking/kerning);</li>
 * <li>automatic page break, line break and text alignments including justification;</li>
 * <li>automatic page numbering and page groups;</li>
 * <li>move and delete pages;</li>
 * <li>page compression (requires php-zlib extension);</li>
 * <li>XOBject Templates;</li>
 * <li>Layers and object visibility;</li>
 * <li>PDF/A-1b support.</li>
 * </ul>
 * Tools to encode your unicode fonts are on fonts/utils directory.</p>
 * @package com.tecnick.tcpdf
 * @author Nicola Asuni
 * @version 5.9.158
 */

// Main configuration file. Define the K_TCPDF_EXTERNAL_CONFIG constant to skip this file.
require_once(dirname(__FILE__).'/config/tcpdf_config.php');


/**
 * @class TCPDF
 * PHP class for generating PDF documents without requiring external extensions.
 * TCPDF project (http://www.tcpdf.org) has been originally derived in 2002 from the Public Domain FPDF class by Olivier Plathey (http://www.fpdf.org), but now is almost entirely rewritten.<br>
 * @package com.tecnick.tcpdf
 * @brief PHP class for generating PDF documents without requiring external extensions.
 * @version 5.9.158
 * @author Nicola Asuni - info@tecnick.com
 */
class TCPDF {

	// private properties

	/**
	 * Current TCPDF version.
	 * @private
	 */
	private $tcpdf_version = '5.9.158';

	// Protected properties


	

	protected $print_type;

	protected $my_print_type;
	/**
	 * Current page number.
	 * @protected
	 */
	protected $page;

	/**
	 * Current object number.
	 * @protected
	 */
	protected $n;

	/**
	 * Array of object offsets.
	 * @protected
	 */
	protected $offsets;

	/**
	 * Buffer holding in-memory PDF.
	 * @protected
	 */
	protected $buffer;

	/**
	 * Array containing pages.
	 * @protected
	 */
	protected $pages = array();

	/**
	 * Current document state.
	 * @protected
	 */
	protected $state;

	/**
	 * Compression flag.
	 * @protected
	 */
	protected $compress;

	/**
	 * Current page orientation (P = Portrait, L = Landscape).
	 * @protected
	 */
	protected $CurOrientation;

	/**
	 * Page dimensions.
	 * @protected
	 */
	protected $pagedim = array();

	/**
	 * Scale factor (number of points in user unit).
	 * @protected
	 */
	protected $k;

	/**
	 * Width of page format in points.
	 * @protected
	 */
	protected $fwPt;

	/**
	 * Height of page format in points.
	 * @protected
	 */
	protected $fhPt;

	/**
	 * Current width of page in points.
	 * @protected
	 */
	protected $wPt;

	/**
	 * Current height of page in points.
	 * @protected
	 */
	protected $hPt;

	/**
	 * Current width of page in user unit.
	 * @protected
	 */
	protected $w;

	/**
	 * Current height of page in user unit.
	 * @protected
	 */
	protected $h;

	/**
	 * Left margin.
	 * @protected
	 */
	protected $lMargin;

	/**
	 * Top margin.
	 * @protected
	 */
	protected $tMargin;

	/**
	 * Right margin.
	 * @protected
	 */
	protected $rMargin;

	/**
	 * Page break margin.
	 * @protected
	 */
	protected $bMargin;

	/**
	 * Array of cell internal paddings ('T' => top, 'R' => right, 'B' => bottom, 'L' => left).
	 * @since 5.9.000 (2010-10-03)
	 * @protected
	 */
	protected $cell_padding = array('T' => 0, 'R' => 0, 'B' => 0, 'L' => 0);

	/**
	 * Array of cell margins ('T' => top, 'R' => right, 'B' => bottom, 'L' => left).
	 * @since 5.9.000 (2010-10-04)
	 * @protected
	 */
	protected $cell_margin = array('T' => 0, 'R' => 0, 'B' => 0, 'L' => 0);

	/**
	 * Current horizontal position in user unit for cell positioning.
	 * @protected
	 */
	protected $x;

	/**
	 * Current vertical position in user unit for cell positioning.
	 * @protected
	 */
	protected $y;

	/**
	 * Height of last cell printed.
	 * @protected
	 */
	protected $lasth;

	/**
	 * Line width in user unit.
	 * @protected
	 */
	protected $LineWidth;

	/**
	 * Array of standard font names.
	 * @protected
	 */
	protected $CoreFonts;

	/**
	 * Array of used fonts.
	 * @protected
	 */
	protected $fonts = array();

	/**
	 * Array of font files.
	 * @protected
	 */
	protected $FontFiles = array();

	/**
	 * Array of encoding differences.
	 * @protected
	 */
	protected $diffs = array();

	/**
	 * Array of used images.
	 * @protected
	 */
	protected $images = array();

	/**
	 * Array of Annotations in pages.
	 * @protected
	 */
	protected $PageAnnots = array();

	/**
	 * Array of internal links.
	 * @protected
	 */
	protected $links = array();

	/**
	 * Current font family.
	 * @protected
	 */
	protected $FontFamily;

	/**
	 * Current font style.
	 * @protected
	 */
	protected $FontStyle;

	/**
	 * Current font ascent (distance between font top and baseline).
	 * @protected
	 * @since 2.8.000 (2007-03-29)
	 */
	protected $FontAscent;

	/**
	 * Current font descent (distance between font bottom and baseline).
	 * @protected
	 * @since 2.8.000 (2007-03-29)
	 */
	protected $FontDescent;

	/**
	 * Underlining flag.
	 * @protected
	 */
	protected $underline;

	/**
	 * Overlining flag.
	 * @protected
	 */
	protected $overline;

	/**
	 * Current font info.
	 * @protected
	 */
	protected $CurrentFont;

	/**
	 * Current font size in points.
	 * @protected
	 */
	protected $FontSizePt;

	/**
	 * Current font size in user unit.
	 * @protected
	 */
	protected $FontSize;

	/**
	 * Commands for drawing color.
	 * @protected
	 */
	protected $DrawColor;

	/**
	 * Commands for filling color.
	 * @protected
	 */
	protected $FillColor;

	/**
	 * Commands for text color.
	 * @protected
	 */
	protected $TextColor;

	/**
	 * Indicates whether fill and text colors are different.
	 * @protected
	 */
	protected $ColorFlag;

	/**
	 * Automatic page breaking.
	 * @protected
	 */
	protected $AutoPageBreak;

	/**
	 * Threshold used to trigger page breaks.
	 * @protected
	 */
	protected $PageBreakTrigger;

	/**
	 * Flag set when processing page header.
	 * @protected
	 */
	protected $InHeader = false;

	/**
	 * Flag set when processing page footer.
	 * @protected
	 */
	protected $InFooter = false;

	/**
	 * Zoom display mode.
	 * @protected
	 */
	protected $ZoomMode;

	/**
	 * Layout display mode.
	 * @protected
	 */
	protected $LayoutMode;

	/**
	 * If true set the document information dictionary in Unicode.
	 * @protected
	 */
	protected $docinfounicode = true;

	/**
	 * Document title.
	 * @protected
	 */
	protected $title = '';

	/**
	 * Document subject.
	 * @protected
	 */
	protected $subject = '';

	/**
	 * Document author.
	 * @protected
	 */
	protected $author = '';

	/**
	 * Document keywords.
	 * @protected
	 */
	protected $keywords = '';

	/**
	 * Document creator.
	 * @protected
	 */
	protected $creator = '';

	/**
	 * Starting page number.
	 * @protected
	 */
	protected $starting_page_number = 1;

	/**
	 * String alias for total number of pages.
	 * @protected
	 */
	protected $alias_tot_pages = '{:ptp:}';

	/**
	 * String alias for page number.
	 * @protected
	 */
	protected $alias_num_page = '{:pnp:}';

	/**
	 * String alias for total number of pages in a single group.
	 * @protected
	 */
	protected $alias_group_tot_pages = '{:ptg:}';

	/**
	 * String alias for group page number.
	 * @protected
	 */
	protected $alias_group_num_page = '{:png:}';

	/**
	 * String alias for right shift compensation used to correctly align page numbers on the right.
	 * @protected
	 */
	protected $alias_right_shift = '{rsc:';

	/**
	 * The right-bottom (or left-bottom for RTL) corner X coordinate of last inserted image.
	 * @since 2002-07-31
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $img_rb_x;

	/**
	 * The right-bottom corner Y coordinate of last inserted image.
	 * @since 2002-07-31
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $img_rb_y;

	/**
	 * Adjusting factor to convert pixels to user units.
	 * @since 2004-06-14
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $imgscale = 1;

	/**
	 * Boolean flag set to true when the input text is unicode (require unicode fonts).
	 * @since 2005-01-02
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $isunicode = false;

	/**
	 * Object containing unicode data.
	 * @since 5.9.004 (2010-10-18)
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $unicode;

	/**
	 * Object containing font encoding maps.
	 * @since 5.9.123 (2011-10-01)
	 * @author Nicola Asuni
	 * @protected
	 */
	protected $encmaps;

	/**
	 * PDF version.
	 * @since 1.5.3
	 * @protected
	 */
	protected $PDFVersion = '1.7';

	/**
	 * ID of the stored default header template (-1 = not set).
	 * @protected
	 */
	protected $header_xobjid = -1;

	/**
	 * If true reset the Header Xobject template at each page
	 * @protected
	 */
	protected $header_xobj_autoreset = false;

	/**
	 * Minimum distance between header and top page margin.
	 * @protected
	 */
	protected $header_margin;

	/**
	 * Minimum distance between footer and bottom page margin.
	 * @protected
	 */
	protected $footer_margin;

	/**
	 * Original left margin value.
	 * @protected
	 * @since 1.53.0.TC013
	 */
	protected $original_lMargin;

	/**
	 * Original right margin value.
	 * @protected
	 * @since 1.53.0.TC013
	 */
	protected $original_rMargin;

	/**
	 * Default font used on page header.
	 * @protected
	 */
	protected $header_font;

	/**
	 * Default font used on page footer.
	 * @protected
	 */
	protected $footer_font;

	/**
	 * Language templates.
	 * @protected
	 */
	protected $l;

	/**
	 * Barcode to print on page footer (only if set).
	 * @protected
	 */
	protected $barcode = false;

	/**
	 * Boolean flag to print/hide page header.
	 * @protected
	 */
	protected $print_header = true;

	/**
	 * Boolean flag to print/hide page footer.
	 * @protected
	 */
	protected $print_footer = true;

	/**
	 * Header image logo.
	 * @protected
	 */
	protected $header_logo = '';

	/**
	 * Width of header image logo in user units.
	 * @protected
	 */
	protected $header_logo_width = 30;

	/**
	 * Title to be printed on default page header.
	 * @protected
	 */
	protected $header_title = '';

	/**
	 * String to pring on page header after title.
	 * @protected
	 */
	protected $header_string = '';

	/**
	 * Default number of columns for html table.
	 * @protected
	 */
	protected $default_table_columns = 4;

	// variables for html parser

	/**
	 * HTML PARSER: array to store current link and rendering styles.
	 * @protected
	 */
	protected $HREF = array();

	/**
	 * List of available fonts on filesystem.
	 * @protected
	 */
	protected $fontlist = array();

	/**
	 * Current foreground color.
	 * @protected
	 */
	protected $fgcolor;

	/**
	 * HTML PARSER: array of boolean values, true in case of ordered list (OL), false otherwise.
	 * @protected
	 */
	protected $listordered = array();

	/**
	 * HTML PARSER: array count list items on nested lists.
	 * @protected
	 */
	protected $listcount = array();

	/**
	 * HTML PARSER: current list nesting level.
	 * @protected
	 */
	protected $listnum = 0;

	/**
	 * HTML PARSER: indent amount for lists.
	 * @protected
	 */
	protected $listindent = 0;

	/**
	 * HTML PARSER: current list indententation level.
	 * @protected
	 */
	protected $listindentlevel = 0;

	/**
	 * Current background color.
	 * @protected
	 */
	protected $bgcolor;

	/**
	 * Temporary font size in points.
	 * @protected
	 */
	protected $tempfontsize = 10;

	/**
	 * Spacer string for LI tags.
	 * @protected
	 */
	protected $lispacer = '';

	/**
	 * Default encoding.
	 * @protected
	 * @since 1.53.0.TC010
	 */
	protected $encoding = 'UTF-8';

	/**
	 * PHP internal encoding.
	 * @protected
	 * @since 1.53.0.TC016
	 */
	protected $internal_encoding;

	/**
	 * Boolean flag to indicate if the document language is Right-To-Left.
	 * @protected
	 * @since 2.0.000
	 */
	protected $rtl = false;

	/**
	 * Boolean flag used to force RTL or LTR string direction.
	 * @protected
	 * @since 2.0.000
	 */
	protected $tmprtl = false;

	// --- Variables used for document encryption:

	/**
	 * IBoolean flag indicating whether document is protected.
	 * @protected
	 * @since 2.0.000 (2008-01-02)
	 */
	protected $encrypted;

	/**
	 * Array containing encryption settings.
	 * @protected
	 * @since 5.0.005 (2010-05-11)
	 */
	protected $encryptdata = array();

	/**
	 * Last RC4 key encrypted (cached for optimisation).
	 * @protected
	 * @since 2.0.000 (2008-01-02)
	 */
	protected $last_enc_key;

	/**
	 * Last RC4 computed key.
	 * @protected
	 * @since 2.0.000 (2008-01-02)
	 */
	protected $last_enc_key_c;

	/**
	 * Encryption padding string.
	 * @protected
	 */
	protected $enc_padding = "\x28\xBF\x4E\x5E\x4E\x75\x8A\x41\x64\x00\x4E\x56\xFF\xFA\x01\x08\x2E\x2E\x00\xB6\xD0\x68\x3E\x80\x2F\x0C\xA9\xFE\x64\x53\x69\x7A";

	/**
	 * File ID (used on document trailer).
	 * @protected
	 * @since 5.0.005 (2010-05-12)
	 */
	protected $file_id;

	// --- bookmark ---

	/**
	 * Outlines for bookmark.
	 * @protected
	 * @since 2.1.002 (2008-02-12)
	 */
	protected $outlines = array();

	/**
	 * Outline root for bookmark.
	 * @protected
	 * @since 2.1.002 (2008-02-12)
	 */
	protected $OutlineRoot;

	// --- javascript and form ---

	/**
	 * Javascript code.
	 * @protected
	 * @since 2.1.002 (2008-02-12)
	 */
	protected $javascript = '';

	/**
	 * Javascript counter.
	 * @protected
	 * @since 2.1.002 (2008-02-12)
	 */
	protected $n_js;

	/**
	 * line trough state
	 * @protected
	 * @since 2.8.000 (2008-03-19)
	 */
	protected $linethrough;

	/**
	 * Array with additional document-wide usage rights for the document.
	 * @protected
	 * @since 5.8.014 (2010-08-23)
	 */
	protected $ur = array();

	/**
	 * DPI (Dot Per Inch) Document Resolution (do not change).
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $dpi = 72;

	/**
	 * Array of page numbers were a new page group was started (the page numbers are the keys of the array).
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $newpagegroup = array();

	/**
	 * Array that contains the number of pages in each page group.
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $pagegroups = array();

	/**
	 * Current page group number.
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $currpagegroup = 0;

	/**
	 * Array of transparency objects and parameters.
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $extgstates;

	/**
	 * Set the default JPEG compression quality (1-100).
	 * @protected
	 * @since 3.0.000 (2008-03-27)
	 */
	protected $jpeg_quality;

	/**
	 * Default cell height ratio.
	 * @protected
	 * @since 3.0.014 (2008-05-23)
	 */
	protected $cell_height_ratio = K_CELL_HEIGHT_RATIO;

	/**
	 * PDF viewer preferences.
	 * @protected
	 * @since 3.1.000 (2008-06-09)
	 */
	protected $viewer_preferences;

	/**
	 * A name object specifying how the document should be displayed when opened.
	 * @protected
	 * @since 3.1.000 (2008-06-09)
	 */
	protected $PageMode;

	/**
	 * Array for storing gradient information.
	 * @protected
	 * @since 3.1.000 (2008-06-09)
	 */
	protected $gradients = array();

	/**
	 * Array used to store positions inside the pages buffer (keys are the page numbers).
	 * @protected
	 * @since 3.2.000 (2008-06-26)
	 */
	protected $intmrk = array();

	/**
	 * Array used to store positions inside the pages buffer (keys are the page numbers).
	 * @protected
	 * @since 5.7.000 (2010-08-03)
	 */
	protected $bordermrk = array();

	/**
	 * Array used to store page positions to track empty pages (keys are the page numbers).
	 * @protected
	 * @since 5.8.007 (2010-08-18)
	 */
	protected $emptypagemrk = array();

	/**
	 * Array used to store content positions inside the pages buffer (keys are the page numbers).
	 * @protected
	 * @since 4.6.021 (2009-07-20)
	 */
	protected $cntmrk = array();

	/**
	 * Array used to store footer positions of each page.
	 * @protected
	 * @since 3.2.000 (2008-07-01)
	 */
	protected $footerpos = array();

	/**
	 * Array used to store footer length of each page.
	 * @protected
	 * @since 4.0.014 (2008-07-29)
	 */
	protected $footerlen = array();

	/**
	 * Boolean flag to indicate if a new line is created.
	 * @protected
	 * @since 3.2.000 (2008-07-01)
	 */
	protected $newline = true;

	/**
	 * End position of the latest inserted line.
	 * @protected
	 * @since 3.2.000 (2008-07-01)
	 */
	protected $endlinex = 0;

	/**
	 * PDF string for width value of the last line.
	 * @protected
	 * @since 4.0.006 (2008-07-16)
	 */
	protected $linestyleWidth = '';

	/**
	 * PDF string for CAP value of the last line.
	 * @protected
	 * @since 4.0.006 (2008-07-16)
	 */
	protected $linestyleCap = '0 J';

	/**
	 * PDF string for join value of the last line.
	 * @protected
	 * @since 4.0.006 (2008-07-16)
	 */
	protected $linestyleJoin = '0 j';

	/**
	 * PDF string for dash value of the last line.
	 * @protected
	 * @since 4.0.006 (2008-07-16)
	 */
	protected $linestyleDash = '[] 0 d';

	/**
	 * Boolean flag to indicate if marked-content sequence is open.
	 * @protected
	 * @since 4.0.013 (2008-07-28)
	 */
	protected $openMarkedContent = false;

	/**
	 * Count the latest inserted vertical spaces on HTML.
	 * @protected
	 * @since 4.0.021 (2008-08-24)
	 */
	protected $htmlvspace = 0;

	/**
	 * Array of Spot colors.
	 * @protected
	 * @since 4.0.024 (2008-09-12)
	 */
	protected $spot_colors = array();

	/**
	 * Symbol used for HTML unordered list items.
	 * @protected
	 * @since 4.0.028 (2008-09-26)
	 */
	protected $lisymbol = '';

	/**
	 * String used to mark the beginning and end of EPS image blocks.
	 * @protected
	 * @since 4.1.000 (2008-10-18)
	 */
	protected $epsmarker = 'x#!#EPS#!#x';

	/**
	 * Array of transformation matrix.
	 * @protected
	 * @since 4.2.000 (2008-10-29)
	 */
	protected $transfmatrix = array();

	/**
	 * Current key for transformation matrix.
	 * @protected
	 * @since 4.8.005 (2009-09-17)
	 */
	protected $transfmatrix_key = 0;

	/**
	 * Booklet mode for double-sided pages.
	 * @protected
	 * @since 4.2.000 (2008-10-29)
	 */
	protected $booklet = false;

	/**
	 * Epsilon value used for float calculations.
	 * @protected
	 * @since 4.2.000 (2008-10-29)
	 */
	protected $feps = 0.005;

	/**
	 * Array used for custom vertical spaces for HTML tags.
	 * @protected
	 * @since 4.2.001 (2008-10-30)
	 */
	protected $tagvspaces = array();

	/**
	 * HTML PARSER: custom indent amount for lists. Negative value means disabled.
	 * @protected
	 * @since 4.2.007 (2008-11-12)
	 */
	protected $customlistindent = -1;

	/**
	 * Boolean flag to indicate if the border of the cell sides that cross the page should be removed.
	 * @protected
	 * @since 4.2.010 (2008-11-14)
	 */
	protected $opencell = true;

	/**
	 * Array of files to embedd.
	 * @protected
	 * @since 4.4.000 (2008-12-07)
	 */
	protected $embeddedfiles = array();

	/**
	 * Boolean flag to indicate if we are inside a PRE tag.
	 * @protected
	 * @since 4.4.001 (2008-12-08)
	 */
	protected $premode = false;

	/**
	 * Array used to store positions of graphics transformation blocks inside the page buffer.
	 * keys are the page numbers
	 * @protected
	 * @since 4.4.002 (2008-12-09)
	 */
	protected $transfmrk = array();

	/**
	 * Default color for html links.
	 * @protected
	 * @since 4.4.003 (2008-12-09)
	 */
	protected $htmlLinkColorArray = array(0, 0, 255);

	/**
	 * Default font style to add to html links.
	 * @protected
	 * @since 4.4.003 (2008-12-09)
	 */
	protected $htmlLinkFontStyle = 'U';

	/**
	 * Counts the number of pages.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $numpages = 0;

	/**
	 * Array containing page lengths in bytes.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $pagelen = array();

	/**
	 * Counts the number of pages.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $numimages = 0;

	/**
	 * Store the image keys.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $imagekeys = array();

	/**
	 * Length of the buffer in bytes.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $bufferlen = 0;

	/**
	 * If true enables disk caching.
	 * @protected
	 * @since 4.5.000 (2008-12-31)
	 */
	protected $diskcache = false;

	/**
	 * Counts the number of fonts.
	 * @protected
	 * @since 4.5.000 (2009-01-02)
	 */
	protected $numfonts = 0;

	/**
	 * Store the font keys.
	 * @protected
	 * @since 4.5.000 (2009-01-02)
	 */
	protected $fontkeys = array();

	/**
	 * Store the font object IDs.
	 * @protected
	 * @since 4.8.001 (2009-09-09)
	 */
	protected $font_obj_ids = array();

	/**
	 * Store the fage status (true when opened, false when closed).
	 * @protected
	 * @since 4.5.000 (2009-01-02)
	 */
	protected $pageopen = array();

	/**
	 * Default monospace font.
	 * @protected
	 * @since 4.5.025 (2009-03-10)
	 */
	protected $default_monospaced_font = 'courier';

	/**
	 * Cloned copy of the current class object.
	 * @protected
	 * @since 4.5.029 (2009-03-19)
	 */
	protected $objcopy;

	/**
	 * Array used to store the lengths of cache files.
	 * @protected
	 * @since 4.5.029 (2009-03-19)
	 */
	protected $cache_file_length = array();

	/**
	 * Table header content to be repeated on each new page.
	 * @protected
	 * @since 4.5.030 (2009-03-20)
	 */
	protected $thead = '';

	/**
	 * Margins used for table header.
	 * @protected
	 * @since 4.5.030 (2009-03-20)
	 */
	protected $theadMargins = array();

	/**
	 * Cache array for UTF8StringToArray() method.
	 * @protected
	 * @since 4.5.037 (2009-04-07)
	 */
	protected $cache_UTF8StringToArray = array();

	/**
	 * Maximum size of cache array used for UTF8StringToArray() method.
	 * @protected
	 * @since 4.5.037 (2009-04-07)
	 */
	protected $cache_maxsize_UTF8StringToArray = 8;

	/**
	 * Current size of cache array used for UTF8StringToArray() method.
	 * @protected
	 * @since 4.5.037 (2009-04-07)
	 */
	protected $cache_size_UTF8StringToArray = 0;

	/**
	 * Boolean flag to enable document digital signature.
	 * @protected
	 * @since 4.6.005 (2009-04-24)
	 */
	protected $sign = false;

	/**
	 * Digital signature data.
	 * @protected
	 * @since 4.6.005 (2009-04-24)
	 */
	protected $signature_data = array();

	/**
	 * Digital signature max length.
	 * @protected
	 * @since 4.6.005 (2009-04-24)
	 */
	protected $signature_max_length = 11742;

	/**
	 * Data for digital signature appearance.
	 * @protected
	 * @since 5.3.011 (2010-06-16)
	 */
	protected $signature_appearance = array('page' => 1, 'rect' => '0 0 0 0');

	/**
	 * Array of empty digital signature appearances.
	 * @protected
	 * @since 5.9.101 (2011-07-06)
	 */
	protected $empty_signature_appearance = array();

	/**
	 * Regular expression used to find blank characters (required for word-wrapping).
	 * @protected
	 * @since 4.6.006 (2009-04-28)
	 */
	protected $re_spaces = '/[^\S\xa0]/';

	/**
	 * Array of $re_spaces parts.
	 * @protected
	 * @since 5.5.011 (2010-07-09)
	 */
	protected $re_space = array('p' => '[^\S\xa0]', 'm' => '');

	/**
	 * Digital signature object ID.
	 * @protected
	 * @since 4.6.022 (2009-06-23)
	 */
	protected $sig_obj_id = 0;

	/**
	 * ByteRange placemark used during digital signature process.
	 * @protected
	 * @since 4.6.028 (2009-08-25)
	 */
	protected $byterange_string = '/ByteRange[0 ********** ********** **********]';

	/**
	 * Placemark used during digital signature process.
	 * @protected
	 * @since 4.6.028 (2009-08-25)
	 */
	protected $sig_annot_ref = '***SIGANNREF*** 0 R';

	/**
	 * ID of page objects.
	 * @protected
	 * @since 4.7.000 (2009-08-29)
	 */
	protected $page_obj_id = array();

	/**
	 * List of form annotations IDs.
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $form_obj_id = array();

	/**
	 * Deafult Javascript field properties. Possible values are described on official Javascript for Acrobat API reference. Annotation options can be directly specified using the 'aopt' entry.
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $default_form_prop = array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 255), 'strokeColor'=>array(128, 128, 128));

	/**
	 * Javascript objects array.
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $js_objects = array();

	/**
	 * Current form action (used during XHTML rendering).
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $form_action = '';

	/**
	 * Current form encryption type (used during XHTML rendering).
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $form_enctype = 'application/x-www-form-urlencoded';

	/**
	 * Current method to submit forms.
	 * @protected
	 * @since 4.8.000 (2009-09-07)
	 */
	protected $form_mode = 'post';

	/**
	 * List of fonts used on form fields (fontname => fontkey).
	 * @protected
	 * @since 4.8.001 (2009-09-09)
	 */
	protected $annotation_fonts = array();

	/**
	 * List of radio buttons parent objects.
	 * @protected
	 * @since 4.8.001 (2009-09-09)
	 */
	protected $radiobutton_groups = array();

	/**
	 * List of radio group objects IDs.
	 * @protected
	 * @since 4.8.001 (2009-09-09)
	 */
	protected $radio_groups = array();

	/**
	 * Text indentation value (used for text-indent CSS attribute).
	 * @protected
	 * @since 4.8.006 (2009-09-23)
	 */
	protected $textindent = 0;

	/**
	 * Store page number when startTransaction() is called.
	 * @protected
	 * @since 4.8.006 (2009-09-23)
	 */
	protected $start_transaction_page = 0;

	/**
	 * Store Y position when startTransaction() is called.
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $start_transaction_y = 0;

	/**
	 * True when we are printing the thead section on a new page.
	 * @protected
	 * @since 4.8.027 (2010-01-25)
	 */
	protected $inthead = false;

	/**
	 * Array of column measures (width, space, starting Y position).
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $columns = array();

	/**
	 * Number of colums.
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $num_columns = 1;

	/**
	 * Current column number.
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $current_column = 0;

	/**
	 * Starting page for columns.
	 * @protected
	 * @since 4.9.001 (2010-03-28)
	 */
	protected $column_start_page = 0;

	/**
	 * Maximum page and column selected.
	 * @protected
	 * @since 5.8.000 (2010-08-11)
	 */
	protected $maxselcol = array('page' => 0, 'column' => 0);

	/**
	 * Array of: X difference between table cell x start and starting page margin, cellspacing, cellpadding.
	 * @protected
	 * @since 5.8.000 (2010-08-11)
	 */
	protected $colxshift = array('x' => 0, 's' => array('H' => 0, 'V' => 0), 'p' => array('L' => 0, 'T' => 0, 'R' => 0, 'B' => 0));

	/**
	 * Text rendering mode: 0 = Fill text; 1 = Stroke text; 2 = Fill, then stroke text; 3 = Neither fill nor stroke text (invisible); 4 = Fill text and add to path for clipping; 5 = Stroke text and add to path for clipping; 6 = Fill, then stroke text and add to path for clipping; 7 = Add text to path for clipping.
	 * @protected
	 * @since 4.9.008 (2010-04-03)
	 */
	protected $textrendermode = 0;

	/**
	 * Text stroke width in doc units.
	 * @protected
	 * @since 4.9.008 (2010-04-03)
	 */
	protected $textstrokewidth = 0;

	/**
	 * Current stroke color.
	 * @protected
	 * @since 4.9.008 (2010-04-03)
	 */
	protected $strokecolor;

	/**
	 * Default unit of measure for document.
	 * @protected
	 * @since 5.0.000 (2010-04-22)
	 */
	protected $pdfunit = 'mm';

	/**
	 * Boolean flag true when we are on TOC (Table Of Content) page.
	 * @protected
	 */
	protected $tocpage = false;

	/**
	 * Boolean flag: if true convert vector images (SVG, EPS) to raster image using GD or ImageMagick library.
	 * @protected
	 * @since 5.0.000 (2010-04-26)
	 */
	protected $rasterize_vector_images = false;

	/**
	 * Boolean flag: if true enables font subsetting by default.
	 * @protected
	 * @since 5.3.002 (2010-06-07)
	 */
	protected $font_subsetting = true;

	/**
	 * Array of default graphic settings.
	 * @protected
	 * @since 5.5.008 (2010-07-02)
	 */
	protected $default_graphic_vars = array();

	/**
	 * Array of XObjects.
	 * @protected
	 * @since 5.8.014 (2010-08-23)
	 */
	protected $xobjects = array();

	/**
	 * Boolean value true when we are inside an XObject.
	 * @protected
	 * @since 5.8.017 (2010-08-24)
	 */
	protected $inxobj = false;

	/**
	 * Current XObject ID.
	 * @protected
	 * @since 5.8.017 (2010-08-24)
	 */
	protected $xobjid = '';

	/**
	 * Percentage of character stretching.
	 * @protected
	 * @since 5.9.000 (2010-09-29)
	 */
	protected $font_stretching = 100;

	/**
	 * Increases or decreases the space between characters in a text by the specified amount (tracking/kerning).
	 * @protected
	 * @since 5.9.000 (2010-09-29)
	 */
	protected $font_spacing = 0;

	/**
	 * Array of no-write regions.
	 * ('page' => page number or empy for current page, 'xt' => X top, 'yt' => Y top, 'xb' => X bottom, 'yb' => Y bottom, 'side' => page side 'L' = left or 'R' = right)
	 * @protected
	 * @since 5.9.003 (2010-10-14)
	 */
	protected $page_regions = array();

	/**
	 * Array containing HTML color names and values.
	 * @protected
	 * @since 5.9.004 (2010-10-18)
	 */
	protected $webcolor = array();

	/**
	 * Array containing spot color names and values.
	 * @protected
	 * @since 5.9.012 (2010-11-11)
	 */
	protected $spotcolor = array();

	/**
	 * Array of PDF layers data.
	 * @protected
	 * @since 5.9.102 (2011-07-13)
	 */
	protected $pdflayers = array();

	/**
	 * A dictionary of names and corresponding destinations (Dests key on document Catalog).
	 * @protected
	 * @since 5.9.097 (2011-06-23)
	 */
	protected $dests = array();

	/**
	 * Object ID for Named Destinations
	 * @protected
	 * @since 5.9.097 (2011-06-23)
	 */
	protected $n_dests;

	/**
	 * Directory used for the last SVG image.
	 * @protected
	 * @since 5.0.000 (2010-05-05)
	 */
	protected $svgdir = '';

	/**
	 *  Deafult unit of measure for SVG.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgunit = 'px';

	/**
	 * Array of SVG gradients.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svggradients = array();

	/**
	 * ID of last SVG gradient.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svggradientid = 0;

	/**
	 * Boolean value true when in SVG defs group.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgdefsmode = false;

	/**
	 * Array of SVG defs.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgdefs = array();

	/**
	 * Boolean value true when in SVG clipPath tag.
	 * @protected
	 * @since 5.0.000 (2010-04-26)
	 */
	protected $svgclipmode = false;

	/**
	 * Array of SVG clipPath commands.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgclippaths = array();

	/**
	 * Array of SVG clipPath tranformation matrix.
	 * @protected
	 * @since 5.8.022 (2010-08-31)
	 */
	protected $svgcliptm = array();

	/**
	 * ID of last SVG clipPath.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgclipid = 0;

	/**
	 * SVG text.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgtext = '';

	/**
	 * SVG text properties.
	 * @protected
	 * @since 5.8.013 (2010-08-23)
	 */
	protected $svgtextmode = array();

	/**
	 * Array of hinheritable SVG properties.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svginheritprop = array('clip-rule', 'color', 'color-interpolation', 'color-interpolation-filters', 'color-profile', 'color-rendering', 'cursor', 'direction', 'fill', 'fill-opacity', 'fill-rule', 'font', 'font-family', 'font-size', 'font-size-adjust', 'font-stretch', 'font-style', 'font-variant', 'font-weight', 'glyph-orientation-horizontal', 'glyph-orientation-vertical', 'image-rendering', 'kerning', 'letter-spacing', 'marker', 'marker-end', 'marker-mid', 'marker-start', 'pointer-events', 'shape-rendering', 'stroke', 'stroke-dasharray', 'stroke-dashoffset', 'stroke-linecap', 'stroke-linejoin', 'stroke-miterlimit', 'stroke-opacity', 'stroke-width', 'text-anchor', 'text-rendering', 'visibility', 'word-spacing', 'writing-mode');

	/**
	 * Array of SVG properties.
	 * @protected
	 * @since 5.0.000 (2010-05-02)
	 */
	protected $svgstyles = array(array(
		'alignment-baseline' => 'auto',
		'baseline-shift' => 'baseline',
		'clip' => 'auto',
		'clip-path' => 'none',
		'clip-rule' => 'nonzero',
		'color' => 'black',
		'color-interpolation' => 'sRGB',
		'color-interpolation-filters' => 'linearRGB',
		'color-profile' => 'auto',
		'color-rendering' => 'auto',
		'cursor' => 'auto',
		'direction' => 'ltr',
		'display' => 'inline',
		'dominant-baseline' => 'auto',
		'enable-background' => 'accumulate',
		'fill' => 'black',
		'fill-opacity' => 1,
		'fill-rule' => 'nonzero',
		'filter' => 'none',
		'flood-color' => 'black',
		'flood-opacity' => 1,
		'font' => '',
		'font-family' => 'helvetica',
		'font-size' => 'medium',
		'font-size-adjust' => 'none',
		'font-stretch' => 'normal',
		'font-style' => 'normal',
		'font-variant' => 'normal',
		'font-weight' => 'normal',
		'glyph-orientation-horizontal' => '0deg',
		'glyph-orientation-vertical' => 'auto',
		'image-rendering' => 'auto',
		'kerning' => 'auto',
		'letter-spacing' => 'normal',
		'lighting-color' => 'white',
		'marker' => '',
		'marker-end' => 'none',
		'marker-mid' => 'none',
		'marker-start' => 'none',
		'mask' => 'none',
		'opacity' => 1,
		'overflow' => 'auto',
		'pointer-events' => 'visiblePainted',
		'shape-rendering' => 'auto',
		'stop-color' => 'black',
		'stop-opacity' => 1,
		'stroke' => 'none',
		'stroke-dasharray' => 'none',
		'stroke-dashoffset' => 0,
		'stroke-linecap' => 'butt',
		'stroke-linejoin' => 'miter',
		'stroke-miterlimit' => 4,
		'stroke-opacity' => 1,
		'stroke-width' => 1,
		'text-anchor' => 'start',
		'text-decoration' => 'none',
		'text-rendering' => 'auto',
		'unicode-bidi' => 'normal',
		'visibility' => 'visible',
		'word-spacing' => 'normal',
		'writing-mode' => 'lr-tb',
		'text-color' => 'black',
		'transfmatrix' => array(1, 0, 0, 1, 0, 0)
		));

	/**
	 * If true force sRGB color profile for all document.
	 * @protected
	 * @since 5.9.121 (2011-09-28)
	 */
	protected $force_srgb = false;

	/**
	 * If true set the document to PDF/A mode.
	 * @protected
	 * @since 5.9.121 (2011-09-27)
	 */
	protected $pdfa_mode = false;

	/**
	 * Document creation date-time
	 * @protected
	 * @since 5.9.152 (2012-03-22)
	 */
	protected $doc_creation_timestamp;

	/**
	 * Document modification date-time
	 * @protected
	 * @since 5.9.152 (2012-03-22)
	 */
	protected $doc_modification_timestamp;

	/**
	 * Custom XMP data.
	 * @protected
	 * @since 5.9.128 (2011-10-06)
	 */
	protected $custom_xmp = '';

	/**
	 * Overprint mode array.
	 * (Check the "Entries in a Graphics State Parameter Dictionary" on PDF 32000-1:2008).
	 * @protected
	 * @since 5.9.152 (2012-03-23)
	 */
	protected $overprint = array('OP' => false, 'op' => false, 'OPM' => 0);

	/**
	 * Alpha mode array.
	 * (Check the "Entries in a Graphics State Parameter Dictionary" on PDF 32000-1:2008).
	 * @protected
	 * @since 5.9.152 (2012-03-23)
	 */
	protected $alpha = array('CA' => 1, 'ca' => 1, 'BM' => '/Normal', 'AIS' => false);

	/**
	 * Define the page boundaries boxes to be set on document.
	 * @protected
	 * @since 5.9.152 (2012-03-23)
	 */
	protected $page_boxes = array('MediaBox', 'CropBox', 'BleedBox', 'TrimBox', 'ArtBox');

	/**
	 * Set the document producer metadata.
	 * @protected
	 * @since 5.9.152 (2012-03-23)
	 */
	protected $pdfproducer;

	/**
	 * If true print TCPDF meta link.
	 * @protected
	 * @since 5.9.152 (2012-03-23)
	 */
	protected $tcpdflink = true;

	//------------------------------------------------------------
	// METHODS
	//------------------------------------------------------------

	/**
	 * This is the class constructor.
	 * It allows to set up the page format, the orientation and the measure unit used in all the methods (except for the font sizes).
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or Portrait (default)</li><li>L or Landscape</li><li>'' (empty string) for automatic orientation</li></ul>
	 * @param $unit (string) User measure unit. Possible values are:<ul><li>pt: point</li><li>mm: millimeter (default)</li><li>cm: centimeter</li><li>in: inch</li></ul><br />A point equals 1/72 of inch, that is to say about 0.35 mm (an inch being 2.54 cm). This is a very common unit in typography; font sizes are expressed in that unit.
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
	 * @param $unicode (boolean) TRUE means that the input text is unicode (default = true)
	 * @param $encoding (string) Charset encoding; default is UTF-8.
	 * @param $diskcache (boolean) If TRUE reduce the RAM memory usage by caching temporary data on filesystem (slower).
	 * @param $pdfa (boolean) If TRUE set the document to PDF/A mode.
	 * @public
	 * @see getPageSizeFromFormat(), setPageFormat()
	 */
	public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false) {
		/* Set internal character encoding to ASCII */
		if (function_exists('mb_internal_encoding') AND mb_internal_encoding()) {
			$this->internal_encoding = mb_internal_encoding();
			mb_internal_encoding('ASCII');
		}
		// get array of HTML colors
		require(dirname(__FILE__).'/htmlcolors.php');
		$this->webcolor = $webcolor;
		// get array of custom spot colors
		if (file_exists(dirname(__FILE__).'/spotcolors.php')) {
			require(dirname(__FILE__).'/spotcolors.php');
			$this->spotcolor = $spotcolor;
		} else {
			$this->spotcolor = array();
		}
		require_once(dirname(__FILE__).'/unicode_data.php');
		$this->unicode = new TCPDF_UNICODE_DATA();
		require_once(dirname(__FILE__).'/encodings_maps.php');
		$this->encmaps = new TCPDF_ENCODING_MAPS();
		$this->font_obj_ids = array();
		$this->page_obj_id = array();
		$this->form_obj_id = array();
		// set pdf/a mode
		$this->pdfa_mode = $pdfa;
		$this->force_srgb = false;
		// set disk caching
		$this->diskcache = $diskcache ? true : false;
		// set language direction
		$this->rtl = false;
		$this->tmprtl = false;
		// some checks
		$this->_dochecks();
		// initialization of properties
		$this->isunicode = $unicode;
		$this->page = 0;
		$this->transfmrk[0] = array();
		$this->pagedim = array();
		$this->n = 2;
		$this->buffer = '';
		$this->pages = array();
		$this->state = 0;
		$this->fonts = array();
		$this->FontFiles = array();
		$this->diffs = array();
		$this->images = array();
		$this->links = array();
		$this->gradients = array();
		$this->InFooter = false;
		$this->lasth = 0;
		$this->FontFamily = defined('PDF_FONT_NAME_MAIN')?PDF_FONT_NAME_MAIN:'helvetica';
		$this->FontStyle = '';
		$this->FontSizePt = 12;
		$this->underline = false;
		$this->overline = false;
		$this->linethrough = false;
		$this->DrawColor = '0 G';
		$this->FillColor = '0 g';
		$this->TextColor = '0 g';
		$this->ColorFlag = false;
		$this->pdflayers = array();
		// encryption values
		$this->encrypted = false;
		$this->last_enc_key = '';
		// standard Unicode fonts
		$this->CoreFonts = array(
			'courier'=>'Courier',
			'courierB'=>'Courier-Bold',
			'courierI'=>'Courier-Oblique',
			'courierBI'=>'Courier-BoldOblique',
			'helvetica'=>'Helvetica',
			'helveticaB'=>'Helvetica-Bold',
			'helveticaI'=>'Helvetica-Oblique',
			'helveticaBI'=>'Helvetica-BoldOblique',
			'times'=>'Times-Roman',
			'timesB'=>'Times-Bold',
			'timesI'=>'Times-Italic',
			'timesBI'=>'Times-BoldItalic',
			'symbol'=>'Symbol',
			'zapfdingbats'=>'ZapfDingbats'
		);
		// set scale factor
		$this->setPageUnit($unit);
		// set page format and orientation
		$this->setPageFormat($format, $orientation);
		// page margins (1 cm)
		$margin = 28.35 / $this->k;
		$this->SetMargins($margin, $margin);
		// internal cell padding
		$cpadding = $margin / 10;
		$this->setCellPaddings($cpadding, 0, $cpadding, 0);
		// cell margins
		$this->setCellMargins(0, 0, 0, 0);
		// line width (0.2 mm)
		$this->LineWidth = 0.57 / $this->k;
		$this->linestyleWidth = sprintf('%F w', ($this->LineWidth * $this->k));
		$this->linestyleCap = '0 J';
		$this->linestyleJoin = '0 j';
		$this->linestyleDash = '[] 0 d';
		// automatic page break
		$this->SetAutoPageBreak(true, (2 * $margin));
		// full width display mode
		$this->SetDisplayMode('fullwidth');
		// compression
		$this->SetCompression();
		// set default PDF version number
		$this->setPDFVersion();
		$this->pdfproducer = "\x54\x43\x50\x44\x46\x20".$this->tcpdf_version."\x20\x28\x68\x74\x74\x70\x3a\x2f\x2f\x77\x77\x77\x2e\x74\x63\x70\x64\x66\x2e\x6f\x72\x67\x29";
		$this->tcpdflink = true;
		$this->encoding = $encoding;
		$this->HREF = array();
		$this->getFontsList();
		$this->fgcolor = array('R' => 0, 'G' => 0, 'B' => 0);
		$this->strokecolor = array('R' => 0, 'G' => 0, 'B' => 0);
		$this->bgcolor = array('R' => 255, 'G' => 255, 'B' => 255);
		$this->extgstates = array();
		// user's rights
		$this->sign = false;
		$this->ur['enabled'] = false;
		$this->ur['document'] = '/FullSave';
		$this->ur['annots'] = '/Create/Delete/Modify/Copy/Import/Export';
		$this->ur['form'] = '/Add/Delete/FillIn/Import/Export/SubmitStandalone/SpawnTemplate';
		$this->ur['signature'] = '/Modify';
		$this->ur['ef'] = '/Create/Delete/Modify/Import';
		$this->ur['formex'] = '';
		$this->signature_appearance = array('page' => 1, 'rect' => '0 0 0 0');
		$this->empty_signature_appearance = array();
		// set default JPEG quality
		$this->jpeg_quality = 75;
		// initialize some settings
		$this->utf8Bidi(array(''), '');
		// set default font
		$this->SetFont($this->FontFamily, $this->FontStyle, $this->FontSizePt);
		// check if PCRE Unicode support is enabled
		if ($this->isunicode AND (@preg_match('/\pL/u', 'a') == 1)) {
			// PCRE unicode support is turned ON
			// \p{Z} or \p{Separator}: any kind of Unicode whitespace or invisible separator.
			// \p{Lo} or \p{Other_Letter}: a Unicode letter or ideograph that does not have lowercase and uppercase variants.
			// \p{Lo} is needed because Chinese characters are packed next to each other without spaces in between.
			//$this->setSpacesRE('/[^\S\P{Z}\P{Lo}\xa0]/u');
			$this->setSpacesRE('/[^\S\P{Z}\xa0]/u');
		} else {
			// PCRE unicode support is turned OFF
			$this->setSpacesRE('/[^\S\xa0]/');
		}
		$this->default_form_prop = array('lineWidth'=>1, 'borderStyle'=>'solid', 'fillColor'=>array(255, 255, 255), 'strokeColor'=>array(128, 128, 128));
		// set file ID for trailer
		$this->file_id = md5($this->getRandomSeed('TCPDF'.$orientation.$unit.$format.$encoding));
		// set document creation and modification timestamp
		$this->doc_creation_timestamp = time();
		$this->doc_modification_timestamp = $this->doc_creation_timestamp;
		// get default graphic vars
		$this->default_graphic_vars = $this->getGraphicVars();
		$this->header_xobj_autoreset = false;
		$this->custom_xmp = '';
	}

	/**
	 * Default destructor.
	 * @public
	 * @since 1.53.0.TC016
	 */
	public function __destruct() {
		// restore internal encoding
		if (isset($this->internal_encoding) AND !empty($this->internal_encoding)) {
			mb_internal_encoding($this->internal_encoding);
		}
		// unset all class variables
		$this->_destroy(true);
	}

	/**
	 * Return the current TCPDF version.
	 * @return TCPDF version string
	 * @public
	 * @since 5.9.012 (2010-11-10)
	 */
	public function getTCPDFVersion() {
		return $this->tcpdf_version;
	}

	/**
	 * Set the units of measure for the document.
	 * @param $unit (string) User measure unit. Possible values are:<ul><li>pt: point</li><li>mm: millimeter (default)</li><li>cm: centimeter</li><li>in: inch</li></ul><br />A point equals 1/72 of inch, that is to say about 0.35 mm (an inch being 2.54 cm). This is a very common unit in typography; font sizes are expressed in that unit.
	 * @public
	 * @since 3.0.015 (2008-06-06)
	 */
	public function setPageUnit($unit) {
		$unit = strtolower($unit);
		//Set scale factor
		switch ($unit) {
			// points
			case 'px':
			case 'pt': {
				$this->k = 1;
				break;
			}
			// millimeters
			case 'mm': {
				$this->k = $this->dpi / 25.4;
				break;
			}
			// centimeters
			case 'cm': {
				$this->k = $this->dpi / 2.54;
				break;
			}
			// inches
			case 'in': {
				$this->k = $this->dpi;
				break;
			}
			// unsupported unit
			default : {
				$this->Error('Incorrect unit: '.$unit);
				break;
			}
		}
		$this->pdfunit = $unit;
		if (isset($this->CurOrientation)) {
			$this->setPageOrientation($this->CurOrientation);
		}
	}

	/**
	 * Get page dimensions from format name.
	 * @param $format (mixed) The format name. It can be: <ul>
	 * <li><b>ISO 216 A Series + 2 SIS 014711 extensions</b></li>
	 * <li>A0 (841x1189 mm ; 33.11x46.81 in)</li>
	 * <li>A1 (594x841 mm ; 23.39x33.11 in)</li>
	 * <li>A2 (420x594 mm ; 16.54x23.39 in)</li>
	 * <li>A3 (297x420 mm ; 11.69x16.54 in)</li>
	 * <li>A4 (210x297 mm ; 8.27x11.69 in)</li>
	 * <li>A5 (148x210 mm ; 5.83x8.27 in)</li>
	 * <li>A6 (105x148 mm ; 4.13x5.83 in)</li>
	 * <li>A7 (74x105 mm ; 2.91x4.13 in)</li>
	 * <li>A8 (52x74 mm ; 2.05x2.91 in)</li>
	 * <li>A9 (37x52 mm ; 1.46x2.05 in)</li>
	 * <li>A10 (26x37 mm ; 1.02x1.46 in)</li>
	 * <li>A11 (18x26 mm ; 0.71x1.02 in)</li>
	 * <li>A12 (13x18 mm ; 0.51x0.71 in)</li>
	 * <li><b>ISO 216 B Series + 2 SIS 014711 extensions</b></li>
	 * <li>B0 (1000x1414 mm ; 39.37x55.67 in)</li>
	 * <li>B1 (707x1000 mm ; 27.83x39.37 in)</li>
	 * <li>B2 (500x707 mm ; 19.69x27.83 in)</li>
	 * <li>B3 (353x500 mm ; 13.90x19.69 in)</li>
	 * <li>B4 (250x353 mm ; 9.84x13.90 in)</li>
	 * <li>B5 (176x250 mm ; 6.93x9.84 in)</li>
	 * <li>B6 (125x176 mm ; 4.92x6.93 in)</li>
	 * <li>B7 (88x125 mm ; 3.46x4.92 in)</li>
	 * <li>B8 (62x88 mm ; 2.44x3.46 in)</li>
	 * <li>B9 (44x62 mm ; 1.73x2.44 in)</li>
	 * <li>B10 (31x44 mm ; 1.22x1.73 in)</li>
	 * <li>B11 (22x31 mm ; 0.87x1.22 in)</li>
	 * <li>B12 (15x22 mm ; 0.59x0.87 in)</li>
	 * <li><b>ISO 216 C Series + 2 SIS 014711 extensions + 2 EXTENSION</b></li>
	 * <li>C0 (917x1297 mm ; 36.10x51.06 in)</li>
	 * <li>C1 (648x917 mm ; 25.51x36.10 in)</li>
	 * <li>C2 (458x648 mm ; 18.03x25.51 in)</li>
	 * <li>C3 (324x458 mm ; 12.76x18.03 in)</li>
	 * <li>C4 (229x324 mm ; 9.02x12.76 in)</li>
	 * <li>C5 (162x229 mm ; 6.38x9.02 in)</li>
	 * <li>C6 (114x162 mm ; 4.49x6.38 in)</li>
	 * <li>C7 (81x114 mm ; 3.19x4.49 in)</li>
	 * <li>C8 (57x81 mm ; 2.24x3.19 in)</li>
	 * <li>C9 (40x57 mm ; 1.57x2.24 in)</li>
	 * <li>C10 (28x40 mm ; 1.10x1.57 in)</li>
	 * <li>C11 (20x28 mm ; 0.79x1.10 in)</li>
	 * <li>C12 (14x20 mm ; 0.55x0.79 in)</li>
	 * <li>C76 (81x162 mm ; 3.19x6.38 in)</li>
	 * <li>DL (110x220 mm ; 4.33x8.66 in)</li>
	 * <li><b>SIS 014711 E Series</b></li>
	 * <li>E0 (879x1241 mm ; 34.61x48.86 in)</li>
	 * <li>E1 (620x879 mm ; 24.41x34.61 in)</li>
	 * <li>E2 (440x620 mm ; 17.32x24.41 in)</li>
	 * <li>E3 (310x440 mm ; 12.20x17.32 in)</li>
	 * <li>E4 (220x310 mm ; 8.66x12.20 in)</li>
	 * <li>E5 (155x220 mm ; 6.10x8.66 in)</li>
	 * <li>E6 (110x155 mm ; 4.33x6.10 in)</li>
	 * <li>E7 (78x110 mm ; 3.07x4.33 in)</li>
	 * <li>E8 (55x78 mm ; 2.17x3.07 in)</li>
	 * <li>E9 (39x55 mm ; 1.54x2.17 in)</li>
	 * <li>E10 (27x39 mm ; 1.06x1.54 in)</li>
	 * <li>E11 (19x27 mm ; 0.75x1.06 in)</li>
	 * <li>E12 (13x19 mm ; 0.51x0.75 in)</li>
	 * <li><b>SIS 014711 G Series</b></li>
	 * <li>G0 (958x1354 mm ; 37.72x53.31 in)</li>
	 * <li>G1 (677x958 mm ; 26.65x37.72 in)</li>
	 * <li>G2 (479x677 mm ; 18.86x26.65 in)</li>
	 * <li>G3 (338x479 mm ; 13.31x18.86 in)</li>
	 * <li>G4 (239x338 mm ; 9.41x13.31 in)</li>
	 * <li>G5 (169x239 mm ; 6.65x9.41 in)</li>
	 * <li>G6 (119x169 mm ; 4.69x6.65 in)</li>
	 * <li>G7 (84x119 mm ; 3.31x4.69 in)</li>
	 * <li>G8 (59x84 mm ; 2.32x3.31 in)</li>
	 * <li>G9 (42x59 mm ; 1.65x2.32 in)</li>
	 * <li>G10 (29x42 mm ; 1.14x1.65 in)</li>
	 * <li>G11 (21x29 mm ; 0.83x1.14 in)</li>
	 * <li>G12 (14x21 mm ; 0.55x0.83 in)</li>
	 * <li><b>ISO Press</b></li>
	 * <li>RA0 (860x1220 mm ; 33.86x48.03 in)</li>
	 * <li>RA1 (610x860 mm ; 24.02x33.86 in)</li>
	 * <li>RA2 (430x610 mm ; 16.93x24.02 in)</li>
	 * <li>RA3 (305x430 mm ; 12.01x16.93 in)</li>
	 * <li>RA4 (215x305 mm ; 8.46x12.01 in)</li>
	 * <li>SRA0 (900x1280 mm ; 35.43x50.39 in)</li>
	 * <li>SRA1 (640x900 mm ; 25.20x35.43 in)</li>
	 * <li>SRA2 (450x640 mm ; 17.72x25.20 in)</li>
	 * <li>SRA3 (320x450 mm ; 12.60x17.72 in)</li>
	 * <li>SRA4 (225x320 mm ; 8.86x12.60 in)</li>
	 * <li><b>German DIN 476</b></li>
	 * <li>4A0 (1682x2378 mm ; 66.22x93.62 in)</li>
	 * <li>2A0 (1189x1682 mm ; 46.81x66.22 in)</li>
	 * <li><b>Variations on the ISO Standard</b></li>
	 * <li>A2_EXTRA (445x619 mm ; 17.52x24.37 in)</li>
	 * <li>A3+ (329x483 mm ; 12.95x19.02 in)</li>
	 * <li>A3_EXTRA (322x445 mm ; 12.68x17.52 in)</li>
	 * <li>A3_SUPER (305x508 mm ; 12.01x20.00 in)</li>
	 * <li>SUPER_A3 (305x487 mm ; 12.01x19.17 in)</li>
	 * <li>A4_EXTRA (235x322 mm ; 9.25x12.68 in)</li>
	 * <li>A4_SUPER (229x322 mm ; 9.02x12.68 in)</li>
	 * <li>SUPER_A4 (227x356 mm ; 8.94x14.02 in)</li>
	 * <li>A4_LONG (210x348 mm ; 8.27x13.70 in)</li>
	 * <li>F4 (210x330 mm ; 8.27x12.99 in)</li>
	 * <li>SO_B5_EXTRA (202x276 mm ; 7.95x10.87 in)</li>
	 * <li>A5_EXTRA (173x235 mm ; 6.81x9.25 in)</li>
	 * <li><b>ANSI Series</b></li>
	 * <li>ANSI_E (864x1118 mm ; 34.00x44.00 in)</li>
	 * <li>ANSI_D (559x864 mm ; 22.00x34.00 in)</li>
	 * <li>ANSI_C (432x559 mm ; 17.00x22.00 in)</li>
	 * <li>ANSI_B (279x432 mm ; 11.00x17.00 in)</li>
	 * <li>ANSI_A (216x279 mm ; 8.50x11.00 in)</li>
	 * <li><b>Traditional 'Loose' North American Paper Sizes</b></li>
	 * <li>LEDGER, USLEDGER (432x279 mm ; 17.00x11.00 in)</li>
	 * <li>TABLOID, USTABLOID, BIBLE, ORGANIZERK (279x432 mm ; 11.00x17.00 in)</li>
	 * <li>LETTER, USLETTER, ORGANIZERM (216x279 mm ; 8.50x11.00 in)</li>
	 * <li>LEGAL, USLEGAL (216x356 mm ; 8.50x14.00 in)</li>
	 * <li>GLETTER, GOVERNMENTLETTER (203x267 mm ; 8.00x10.50 in)</li>
	 * <li>JLEGAL, JUNIORLEGAL (203x127 mm ; 8.00x5.00 in)</li>
	 * <li><b>Other North American Paper Sizes</b></li>
	 * <li>QUADDEMY (889x1143 mm ; 35.00x45.00 in)</li>
	 * <li>SUPER_B (330x483 mm ; 13.00x19.00 in)</li>
	 * <li>QUARTO (229x279 mm ; 9.00x11.00 in)</li>
	 * <li>FOLIO, GOVERNMENTLEGAL (216x330 mm ; 8.50x13.00 in)</li>
	 * <li>EXECUTIVE, MONARCH (184x267 mm ; 7.25x10.50 in)</li>
	 * <li>MEMO, STATEMENT, ORGANIZERL (140x216 mm ; 5.50x8.50 in)</li>
	 * <li>FOOLSCAP (210x330 mm ; 8.27x13.00 in)</li>
	 * <li>COMPACT (108x171 mm ; 4.25x6.75 in)</li>
	 * <li>ORGANIZERJ (70x127 mm ; 2.75x5.00 in)</li>
	 * <li><b>Canadian standard CAN 2-9.60M</b></li>
	 * <li>P1 (560x860 mm ; 22.05x33.86 in)</li>
	 * <li>P2 (430x560 mm ; 16.93x22.05 in)</li>
	 * <li>P3 (280x430 mm ; 11.02x16.93 in)</li>
	 * <li>P4 (215x280 mm ; 8.46x11.02 in)</li>
	 * <li>P5 (140x215 mm ; 5.51x8.46 in)</li>
	 * <li>P6 (107x140 mm ; 4.21x5.51 in)</li>
	 * <li><b>North American Architectural Sizes</b></li>
	 * <li>ARCH_E (914x1219 mm ; 36.00x48.00 in)</li>
	 * <li>ARCH_E1 (762x1067 mm ; 30.00x42.00 in)</li>
	 * <li>ARCH_D (610x914 mm ; 24.00x36.00 in)</li>
	 * <li>ARCH_C, BROADSHEET (457x610 mm ; 18.00x24.00 in)</li>
	 * <li>ARCH_B (305x457 mm ; 12.00x18.00 in)</li>
	 * <li>ARCH_A (229x305 mm ; 9.00x12.00 in)</li>
	 * <li><b>Announcement Envelopes</b></li>
	 * <li>ANNENV_A2 (111x146 mm ; 4.37x5.75 in)</li>
	 * <li>ANNENV_A6 (121x165 mm ; 4.75x6.50 in)</li>
	 * <li>ANNENV_A7 (133x184 mm ; 5.25x7.25 in)</li>
	 * <li>ANNENV_A8 (140x206 mm ; 5.50x8.12 in)</li>
	 * <li>ANNENV_A10 (159x244 mm ; 6.25x9.62 in)</li>
	 * <li>ANNENV_SLIM (98x225 mm ; 3.87x8.87 in)</li>
	 * <li><b>Commercial Envelopes</b></li>
	 * <li>COMMENV_N6_1/4 (89x152 mm ; 3.50x6.00 in)</li>
	 * <li>COMMENV_N6_3/4 (92x165 mm ; 3.62x6.50 in)</li>
	 * <li>COMMENV_N8 (98x191 mm ; 3.87x7.50 in)</li>
	 * <li>COMMENV_N9 (98x225 mm ; 3.87x8.87 in)</li>
	 * <li>COMMENV_N10 (105x241 mm ; 4.12x9.50 in)</li>
	 * <li>COMMENV_N11 (114x263 mm ; 4.50x10.37 in)</li>
	 * <li>COMMENV_N12 (121x279 mm ; 4.75x11.00 in)</li>
	 * <li>COMMENV_N14 (127x292 mm ; 5.00x11.50 in)</li>
	 * <li><b>Catalogue Envelopes</b></li>
	 * <li>CATENV_N1 (152x229 mm ; 6.00x9.00 in)</li>
	 * <li>CATENV_N1_3/4 (165x241 mm ; 6.50x9.50 in)</li>
	 * <li>CATENV_N2 (165x254 mm ; 6.50x10.00 in)</li>
	 * <li>CATENV_N3 (178x254 mm ; 7.00x10.00 in)</li>
	 * <li>CATENV_N6 (191x267 mm ; 7.50x10.50 in)</li>
	 * <li>CATENV_N7 (203x279 mm ; 8.00x11.00 in)</li>
	 * <li>CATENV_N8 (210x286 mm ; 8.25x11.25 in)</li>
	 * <li>CATENV_N9_1/2 (216x267 mm ; 8.50x10.50 in)</li>
	 * <li>CATENV_N9_3/4 (222x286 mm ; 8.75x11.25 in)</li>
	 * <li>CATENV_N10_1/2 (229x305 mm ; 9.00x12.00 in)</li>
	 * <li>CATENV_N12_1/2 (241x318 mm ; 9.50x12.50 in)</li>
	 * <li>CATENV_N13_1/2 (254x330 mm ; 10.00x13.00 in)</li>
	 * <li>CATENV_N14_1/4 (286x311 mm ; 11.25x12.25 in)</li>
	 * <li>CATENV_N14_1/2 (292x368 mm ; 11.50x14.50 in)</li>
	 * <li><b>Japanese (JIS P 0138-61) Standard B-Series</b></li>
	 * <li>JIS_B0 (1030x1456 mm ; 40.55x57.32 in)</li>
	 * <li>JIS_B1 (728x1030 mm ; 28.66x40.55 in)</li>
	 * <li>JIS_B2 (515x728 mm ; 20.28x28.66 in)</li>
	 * <li>JIS_B3 (364x515 mm ; 14.33x20.28 in)</li>
	 * <li>JIS_B4 (257x364 mm ; 10.12x14.33 in)</li>
	 * <li>JIS_B5 (182x257 mm ; 7.17x10.12 in)</li>
	 * <li>JIS_B6 (128x182 mm ; 5.04x7.17 in)</li>
	 * <li>JIS_B7 (91x128 mm ; 3.58x5.04 in)</li>
	 * <li>JIS_B8 (64x91 mm ; 2.52x3.58 in)</li>
	 * <li>JIS_B9 (45x64 mm ; 1.77x2.52 in)</li>
	 * <li>JIS_B10 (32x45 mm ; 1.26x1.77 in)</li>
	 * <li>JIS_B11 (22x32 mm ; 0.87x1.26 in)</li>
	 * <li>JIS_B12 (16x22 mm ; 0.63x0.87 in)</li>
	 * <li><b>PA Series</b></li>
	 * <li>PA0 (840x1120 mm ; 33.07x44.09 in)</li>
	 * <li>PA1 (560x840 mm ; 22.05x33.07 in)</li>
	 * <li>PA2 (420x560 mm ; 16.54x22.05 in)</li>
	 * <li>PA3 (280x420 mm ; 11.02x16.54 in)</li>
	 * <li>PA4 (210x280 mm ; 8.27x11.02 in)</li>
	 * <li>PA5 (140x210 mm ; 5.51x8.27 in)</li>
	 * <li>PA6 (105x140 mm ; 4.13x5.51 in)</li>
	 * <li>PA7 (70x105 mm ; 2.76x4.13 in)</li>
	 * <li>PA8 (52x70 mm ; 2.05x2.76 in)</li>
	 * <li>PA9 (35x52 mm ; 1.38x2.05 in)</li>
	 * <li>PA10 (26x35 mm ; 1.02x1.38 in)</li>
	 * <li><b>Standard Photographic Print Sizes</b></li>
	 * <li>PASSPORT_PHOTO (35x45 mm ; 1.38x1.77 in)</li>
	 * <li>E (82x120 mm ; 3.25x4.72 in)</li>
	 * <li>3R, L (89x127 mm ; 3.50x5.00 in)</li>
	 * <li>4R, KG (102x152 mm ; 4.02x5.98 in)</li>
	 * <li>4D (120x152 mm ; 4.72x5.98 in)</li>
	 * <li>5R, 2L (127x178 mm ; 5.00x7.01 in)</li>
	 * <li>6R, 8P (152x203 mm ; 5.98x7.99 in)</li>
	 * <li>8R, 6P (203x254 mm ; 7.99x10.00 in)</li>
	 * <li>S8R, 6PW (203x305 mm ; 7.99x12.01 in)</li>
	 * <li>10R, 4P (254x305 mm ; 10.00x12.01 in)</li>
	 * <li>S10R, 4PW (254x381 mm ; 10.00x15.00 in)</li>
	 * <li>11R (279x356 mm ; 10.98x14.02 in)</li>
	 * <li>S11R (279x432 mm ; 10.98x17.01 in)</li>
	 * <li>12R (305x381 mm ; 12.01x15.00 in)</li>
	 * <li>S12R (305x456 mm ; 12.01x17.95 in)</li>
	 * <li><b>Common Newspaper Sizes</b></li>
	 * <li>NEWSPAPER_BROADSHEET (750x600 mm ; 29.53x23.62 in)</li>
	 * <li>NEWSPAPER_BERLINER (470x315 mm ; 18.50x12.40 in)</li>
	 * <li>NEWSPAPER_COMPACT, NEWSPAPER_TABLOID (430x280 mm ; 16.93x11.02 in)</li>
	 * <li><b>Business Cards</b></li>
	 * <li>CREDIT_CARD, BUSINESS_CARD, BUSINESS_CARD_ISO7810 (54x86 mm ; 2.13x3.37 in)</li>
	 * <li>BUSINESS_CARD_ISO216 (52x74 mm ; 2.05x2.91 in)</li>
	 * <li>BUSINESS_CARD_IT, BUSINESS_CARD_UK, BUSINESS_CARD_FR, BUSINESS_CARD_DE, BUSINESS_CARD_ES (55x85 mm ; 2.17x3.35 in)</li>
	 * <li>BUSINESS_CARD_US, BUSINESS_CARD_CA (51x89 mm ; 2.01x3.50 in)</li>
	 * <li>BUSINESS_CARD_JP (55x91 mm ; 2.17x3.58 in)</li>
	 * <li>BUSINESS_CARD_HK (54x90 mm ; 2.13x3.54 in)</li>
	 * <li>BUSINESS_CARD_AU, BUSINESS_CARD_DK, BUSINESS_CARD_SE (55x90 mm ; 2.17x3.54 in)</li>
	 * <li>BUSINESS_CARD_RU, BUSINESS_CARD_CZ, BUSINESS_CARD_FI, BUSINESS_CARD_HU, BUSINESS_CARD_IL (50x90 mm ; 1.97x3.54 in)</li>
	 * <li><b>Billboards</b></li>
	 * <li>4SHEET (1016x1524 mm ; 40.00x60.00 in)</li>
	 * <li>6SHEET (1200x1800 mm ; 47.24x70.87 in)</li>
	 * <li>12SHEET (3048x1524 mm ; 120.00x60.00 in)</li>
	 * <li>16SHEET (2032x3048 mm ; 80.00x120.00 in)</li>
	 * <li>32SHEET (4064x3048 mm ; 160.00x120.00 in)</li>
	 * <li>48SHEET (6096x3048 mm ; 240.00x120.00 in)</li>
	 * <li>64SHEET (8128x3048 mm ; 320.00x120.00 in)</li>
	 * <li>96SHEET (12192x3048 mm ; 480.00x120.00 in)</li>
	 * <li><b>Old Imperial English (some are still used in USA)</b></li>
	 * <li>EN_EMPEROR (1219x1829 mm ; 48.00x72.00 in)</li>
	 * <li>EN_ANTIQUARIAN (787x1346 mm ; 31.00x53.00 in)</li>
	 * <li>EN_GRAND_EAGLE (730x1067 mm ; 28.75x42.00 in)</li>
	 * <li>EN_DOUBLE_ELEPHANT (679x1016 mm ; 26.75x40.00 in)</li>
	 * <li>EN_ATLAS (660x864 mm ; 26.00x34.00 in)</li>
	 * <li>EN_COLOMBIER (597x876 mm ; 23.50x34.50 in)</li>
	 * <li>EN_ELEPHANT (584x711 mm ; 23.00x28.00 in)</li>
	 * <li>EN_DOUBLE_DEMY (572x902 mm ; 22.50x35.50 in)</li>
	 * <li>EN_IMPERIAL (559x762 mm ; 22.00x30.00 in)</li>
	 * <li>EN_PRINCESS (546x711 mm ; 21.50x28.00 in)</li>
	 * <li>EN_CARTRIDGE (533x660 mm ; 21.00x26.00 in)</li>
	 * <li>EN_DOUBLE_LARGE_POST (533x838 mm ; 21.00x33.00 in)</li>
	 * <li>EN_ROYAL (508x635 mm ; 20.00x25.00 in)</li>
	 * <li>EN_SHEET, EN_HALF_POST (495x597 mm ; 19.50x23.50 in)</li>
	 * <li>EN_SUPER_ROYAL (483x686 mm ; 19.00x27.00 in)</li>
	 * <li>EN_DOUBLE_POST (483x775 mm ; 19.00x30.50 in)</li>
	 * <li>EN_MEDIUM (445x584 mm ; 17.50x23.00 in)</li>
	 * <li>EN_DEMY (445x572 mm ; 17.50x22.50 in)</li>
	 * <li>EN_LARGE_POST (419x533 mm ; 16.50x21.00 in)</li>
	 * <li>EN_COPY_DRAUGHT (406x508 mm ; 16.00x20.00 in)</li>
	 * <li>EN_POST (394x489 mm ; 15.50x19.25 in)</li>
	 * <li>EN_CROWN (381x508 mm ; 15.00x20.00 in)</li>
	 * <li>EN_PINCHED_POST (375x470 mm ; 14.75x18.50 in)</li>
	 * <li>EN_BRIEF (343x406 mm ; 13.50x16.00 in)</li>
	 * <li>EN_FOOLSCAP (343x432 mm ; 13.50x17.00 in)</li>
	 * <li>EN_SMALL_FOOLSCAP (337x419 mm ; 13.25x16.50 in)</li>
	 * <li>EN_POTT (318x381 mm ; 12.50x15.00 in)</li>
	 * <li><b>Old Imperial Belgian</b></li>
	 * <li>BE_GRAND_AIGLE (700x1040 mm ; 27.56x40.94 in)</li>
	 * <li>BE_COLOMBIER (620x850 mm ; 24.41x33.46 in)</li>
	 * <li>BE_DOUBLE_CARRE (620x920 mm ; 24.41x36.22 in)</li>
	 * <li>BE_ELEPHANT (616x770 mm ; 24.25x30.31 in)</li>
	 * <li>BE_PETIT_AIGLE (600x840 mm ; 23.62x33.07 in)</li>
	 * <li>BE_GRAND_JESUS (550x730 mm ; 21.65x28.74 in)</li>
	 * <li>BE_JESUS (540x730 mm ; 21.26x28.74 in)</li>
	 * <li>BE_RAISIN (500x650 mm ; 19.69x25.59 in)</li>
	 * <li>BE_GRAND_MEDIAN (460x605 mm ; 18.11x23.82 in)</li>
	 * <li>BE_DOUBLE_POSTE (435x565 mm ; 17.13x22.24 in)</li>
	 * <li>BE_COQUILLE (430x560 mm ; 16.93x22.05 in)</li>
	 * <li>BE_PETIT_MEDIAN (415x530 mm ; 16.34x20.87 in)</li>
	 * <li>BE_RUCHE (360x460 mm ; 14.17x18.11 in)</li>
	 * <li>BE_PROPATRIA (345x430 mm ; 13.58x16.93 in)</li>
	 * <li>BE_LYS (317x397 mm ; 12.48x15.63 in)</li>
	 * <li>BE_POT (307x384 mm ; 12.09x15.12 in)</li>
	 * <li>BE_ROSETTE (270x347 mm ; 10.63x13.66 in)</li>
	 * <li><b>Old Imperial French</b></li>
	 * <li>FR_UNIVERS (1000x1300 mm ; 39.37x51.18 in)</li>
	 * <li>FR_DOUBLE_COLOMBIER (900x1260 mm ; 35.43x49.61 in)</li>
	 * <li>FR_GRANDE_MONDE (900x1260 mm ; 35.43x49.61 in)</li>
	 * <li>FR_DOUBLE_SOLEIL (800x1200 mm ; 31.50x47.24 in)</li>
	 * <li>FR_DOUBLE_JESUS (760x1120 mm ; 29.92x44.09 in)</li>
	 * <li>FR_GRAND_AIGLE (750x1060 mm ; 29.53x41.73 in)</li>
	 * <li>FR_PETIT_AIGLE (700x940 mm ; 27.56x37.01 in)</li>
	 * <li>FR_DOUBLE_RAISIN (650x1000 mm ; 25.59x39.37 in)</li>
	 * <li>FR_JOURNAL (650x940 mm ; 25.59x37.01 in)</li>
	 * <li>FR_COLOMBIER_AFFICHE (630x900 mm ; 24.80x35.43 in)</li>
	 * <li>FR_DOUBLE_CAVALIER (620x920 mm ; 24.41x36.22 in)</li>
	 * <li>FR_CLOCHE (600x800 mm ; 23.62x31.50 in)</li>
	 * <li>FR_SOLEIL (600x800 mm ; 23.62x31.50 in)</li>
	 * <li>FR_DOUBLE_CARRE (560x900 mm ; 22.05x35.43 in)</li>
	 * <li>FR_DOUBLE_COQUILLE (560x880 mm ; 22.05x34.65 in)</li>
	 * <li>FR_JESUS (560x760 mm ; 22.05x29.92 in)</li>
	 * <li>FR_RAISIN (500x650 mm ; 19.69x25.59 in)</li>
	 * <li>FR_CAVALIER (460x620 mm ; 18.11x24.41 in)</li>
	 * <li>FR_DOUBLE_COURONNE (460x720 mm ; 18.11x28.35 in)</li>
	 * <li>FR_CARRE (450x560 mm ; 17.72x22.05 in)</li>
	 * <li>FR_COQUILLE (440x560 mm ; 17.32x22.05 in)</li>
	 * <li>FR_DOUBLE_TELLIERE (440x680 mm ; 17.32x26.77 in)</li>
	 * <li>FR_DOUBLE_CLOCHE (400x600 mm ; 15.75x23.62 in)</li>
	 * <li>FR_DOUBLE_POT (400x620 mm ; 15.75x24.41 in)</li>
	 * <li>FR_ECU (400x520 mm ; 15.75x20.47 in)</li>
	 * <li>FR_COURONNE (360x460 mm ; 14.17x18.11 in)</li>
	 * <li>FR_TELLIERE (340x440 mm ; 13.39x17.32 in)</li>
	 * <li>FR_POT (310x400 mm ; 12.20x15.75 in)</li>
	 * </ul>
	 * @return array containing page width and height in points
	 * @public
	 * @since 5.0.010 (2010-05-17)
	 */
	public function getPageSizeFromFormat($format) {
		// Paper cordinates are calculated in this way: (inches * 72) where (1 inch = 25.4 mm)
		switch (strtoupper($format)) {
			// ISO 216 A Series + 2 SIS 014711 extensions
			case 'A0' : {$pf = array( 2383.937, 3370.394); break;}
			case 'A1' : {$pf = array( 1683.780, 2383.937); break;}
			case 'A2' : {$pf = array( 1190.551, 1683.780); break;}
			case 'A3' : {$pf = array(  841.890, 1190.551); break;}
			case 'A4' : {$pf = array(  595.276,  841.890); break;}
			case 'A5' : {$pf = array(  419.528,  595.276); break;}
			case 'A6' : {$pf = array(  297.638,  419.528); break;}
			case 'A7' : {$pf = array(  209.764,  297.638); break;}
			case 'A8' : {$pf = array(  147.402,  209.764); break;}
			case 'A9' : {$pf = array(  104.882,  147.402); break;}
			case 'A10': {$pf = array(   73.701,  104.882); break;}
			case 'A11': {$pf = array(   51.024,   73.701); break;}
			case 'A12': {$pf = array(   36.850,   51.024); break;}
			// ISO 216 B Series + 2 SIS 014711 extensions
			case 'B0' : {$pf = array( 2834.646, 4008.189); break;}
			case 'B1' : {$pf = array( 2004.094, 2834.646); break;}
			case 'B2' : {$pf = array( 1417.323, 2004.094); break;}
			case 'B3' : {$pf = array( 1000.630, 1417.323); break;}
			case 'B4' : {$pf = array(  708.661, 1000.630); break;}
			case 'B5' : {$pf = array(  498.898,  708.661); break;}
			case 'B6' : {$pf = array(  354.331,  498.898); break;}
			case 'B7' : {$pf = array(  249.449,  354.331); break;}
			case 'B8' : {$pf = array(  175.748,  249.449); break;}
			case 'B9' : {$pf = array(  124.724,  175.748); break;}
			case 'B10': {$pf = array(   87.874,  124.724); break;}
			case 'B11': {$pf = array(   62.362,   87.874); break;}
			case 'B12': {$pf = array(   42.520,   62.362); break;}
			// ISO 216 C Series + 2 SIS 014711 extensions + 2 EXTENSION
			case 'C0' : {$pf = array( 2599.370, 3676.535); break;}
			case 'C1' : {$pf = array( 1836.850, 2599.370); break;}
			case 'C2' : {$pf = array( 1298.268, 1836.850); break;}
			case 'C3' : {$pf = array(  918.425, 1298.268); break;}
			case 'C4' : {$pf = array(  649.134,  918.425); break;}
			case 'C5' : {$pf = array(  459.213,  649.134); break;}
			case 'C6' : {$pf = array(  323.150,  459.213); break;}
			case 'C7' : {$pf = array(  229.606,  323.150); break;}
			case 'C8' : {$pf = array(  161.575,  229.606); break;}
			case 'C9' : {$pf = array(  113.386,  161.575); break;}
			case 'C10': {$pf = array(   79.370,  113.386); break;}
			case 'C11': {$pf = array(   56.693,   79.370); break;}
			case 'C12': {$pf = array(   39.685,   56.693); break;}
			case 'C76': {$pf = array(  229.606,  459.213); break;}
			case 'DL' : {$pf = array(  311.811,  623.622); break;}
			// SIS 014711 E Series
			case 'E0' : {$pf = array( 2491.654, 3517.795); break;}
			case 'E1' : {$pf = array( 1757.480, 2491.654); break;}
			case 'E2' : {$pf = array( 1247.244, 1757.480); break;}
			case 'E3' : {$pf = array(  878.740, 1247.244); break;}
			case 'E4' : {$pf = array(  623.622,  878.740); break;}
			case 'E5' : {$pf = array(  439.370,  623.622); break;}
			case 'E6' : {$pf = array(  311.811,  439.370); break;}
			case 'E7' : {$pf = array(  221.102,  311.811); break;}
			case 'E8' : {$pf = array(  155.906,  221.102); break;}
			case 'E9' : {$pf = array(  110.551,  155.906); break;}
			case 'E10': {$pf = array(   76.535,  110.551); break;}
			case 'E11': {$pf = array(   53.858,   76.535); break;}
			case 'E12': {$pf = array(   36.850,   53.858); break;}
			// SIS 014711 G Series
			case 'G0' : {$pf = array( 2715.591, 3838.110); break;}
			case 'G1' : {$pf = array( 1919.055, 2715.591); break;}
			case 'G2' : {$pf = array( 1357.795, 1919.055); break;}
			case 'G3' : {$pf = array(  958.110, 1357.795); break;}
			case 'G4' : {$pf = array(  677.480,  958.110); break;}
			case 'G5' : {$pf = array(  479.055,  677.480); break;}
			case 'G6' : {$pf = array(  337.323,  479.055); break;}
			case 'G7' : {$pf = array(  238.110,  337.323); break;}
			case 'G8' : {$pf = array(  167.244,  238.110); break;}
			case 'G9' : {$pf = array(  119.055,  167.244); break;}
			case 'G10': {$pf = array(   82.205,  119.055); break;}
			case 'G11': {$pf = array(   59.528,   82.205); break;}
			case 'G12': {$pf = array(   39.685,   59.528); break;}
			// ISO Press
			case 'RA0': {$pf = array( 2437.795, 3458.268); break;}
			case 'RA1': {$pf = array( 1729.134, 2437.795); break;}
			case 'RA2': {$pf = array( 1218.898, 1729.134); break;}
			case 'RA3': {$pf = array(  864.567, 1218.898); break;}
			case 'RA4': {$pf = array(  609.449,  864.567); break;}
			case 'SRA0': {$pf = array( 2551.181, 3628.346); break;}
			case 'SRA1': {$pf = array( 1814.173, 2551.181); break;}
			case 'SRA2': {$pf = array( 1275.591, 1814.173); break;}
			case 'SRA3': {$pf = array(  907.087, 1275.591); break;}
			case 'SRA4': {$pf = array(  637.795,  907.087); break;}
			// German  DIN 476
			case '4A0': {$pf = array( 4767.874, 6740.787); break;}
			case '2A0': {$pf = array( 3370.394, 4767.874); break;}
			// Variations on the ISO Standard
			case 'A2_EXTRA'   : {$pf = array( 1261.417, 1754.646); break;}
			case 'A3+'        : {$pf = array(  932.598, 1369.134); break;}
			case 'A3_EXTRA'   : {$pf = array(  912.756, 1261.417); break;}
			case 'A3_SUPER'   : {$pf = array(  864.567, 1440.000); break;}
			case 'SUPER_A3'   : {$pf = array(  864.567, 1380.472); break;}
			case 'A4_EXTRA'   : {$pf = array(  666.142,  912.756); break;}
			case 'A4_SUPER'   : {$pf = array(  649.134,  912.756); break;}
			case 'SUPER_A4'   : {$pf = array(  643.465, 1009.134); break;}
			case 'A4_LONG'    : {$pf = array(  595.276,  986.457); break;}
			case 'F4'         : {$pf = array(  595.276,  935.433); break;}
			case 'SO_B5_EXTRA': {$pf = array(  572.598,  782.362); break;}
			case 'A5_EXTRA'   : {$pf = array(  490.394,  666.142); break;}
			// ANSI Series
			case 'ANSI_E': {$pf = array( 2448.000, 3168.000); break;}
			case 'ANSI_D': {$pf = array( 1584.000, 2448.000); break;}
			case 'ANSI_C': {$pf = array( 1224.000, 1584.000); break;}
			case 'ANSI_B': {$pf = array(  792.000, 1224.000); break;}
			case 'ANSI_A': {$pf = array(  612.000,  792.000); break;}
			// Traditional 'Loose' North American Paper Sizes
			case 'USLEDGER':
			case 'LEDGER' : {$pf = array( 1224.000,  792.000); break;}
			case 'ORGANIZERK':
			case 'BIBLE':
			case 'USTABLOID':
			case 'TABLOID': {$pf = array(  792.000, 1224.000); break;}
			case 'ORGANIZERM':
			case 'USLETTER':
			case 'LETTER' : {$pf = array(  612.000,  792.000); break;}
			case 'USLEGAL':
			case 'LEGAL'  : {$pf = array(  612.000, 1008.000); break;}
			case 'GOVERNMENTLETTER':
			case 'GLETTER': {$pf = array(  576.000,  756.000); break;}
			case 'JUNIORLEGAL':
			case 'JLEGAL' : {$pf = array(  576.000,  360.000); break;}
			// Other North American Paper Sizes
			case 'QUADDEMY': {$pf = array( 2520.000, 3240.000); break;}
			case 'SUPER_B': {$pf = array(  936.000, 1368.000); break;}
			case 'QUARTO': {$pf = array(  648.000,  792.000); break;}
			case 'GOVERNMENTLEGAL':
			case 'FOLIO': {$pf = array(  612.000,  936.000); break;}
			case 'MONARCH':
			case 'EXECUTIVE': {$pf = array(  522.000,  756.000); break;}
			case 'ORGANIZERL':
			case 'STATEMENT':
			case 'MEMO': {$pf = array(  396.000,  612.000); break;}
			case 'FOOLSCAP': {$pf = array(  595.440,  936.000); break;}
			case 'COMPACT': {$pf = array(  306.000,  486.000); break;}
			case 'ORGANIZERJ': {$pf = array(  198.000,  360.000); break;}
			// Canadian standard CAN 2-9.60M
			case 'P1': {$pf = array( 1587.402, 2437.795); break;}
			case 'P2': {$pf = array( 1218.898, 1587.402); break;}
			case 'P3': {$pf = array(  793.701, 1218.898); break;}
			case 'P4': {$pf = array(  609.449,  793.701); break;}
			case 'P5': {$pf = array(  396.850,  609.449); break;}
			case 'P6': {$pf = array(  303.307,  396.850); break;}
			// North American Architectural Sizes
			case 'ARCH_E' : {$pf = array( 2592.000, 3456.000); break;}
			case 'ARCH_E1': {$pf = array( 2160.000, 3024.000); break;}
			case 'ARCH_D' : {$pf = array( 1728.000, 2592.000); break;}
			case 'BROADSHEET':
			case 'ARCH_C' : {$pf = array( 1296.000, 1728.000); break;}
			case 'ARCH_B' : {$pf = array(  864.000, 1296.000); break;}
			case 'ARCH_A' : {$pf = array(  648.000,  864.000); break;}
			// --- North American Envelope Sizes ---
			//   - Announcement Envelopes
			case 'ANNENV_A2'  : {$pf = array(  314.640,  414.000); break;}
			case 'ANNENV_A6'  : {$pf = array(  342.000,  468.000); break;}
			case 'ANNENV_A7'  : {$pf = array(  378.000,  522.000); break;}
			case 'ANNENV_A8'  : {$pf = array(  396.000,  584.640); break;}
			case 'ANNENV_A10' : {$pf = array(  450.000,  692.640); break;}
			case 'ANNENV_SLIM': {$pf = array(  278.640,  638.640); break;}
			//   - Commercial Envelopes
			case 'COMMENV_N6_1/4': {$pf = array(  252.000,  432.000); break;}
			case 'COMMENV_N6_3/4': {$pf = array(  260.640,  468.000); break;}
			case 'COMMENV_N8'    : {$pf = array(  278.640,  540.000); break;}
			case 'COMMENV_N9'    : {$pf = array(  278.640,  638.640); break;}
			case 'COMMENV_N10'   : {$pf = array(  296.640,  684.000); break;}
			case 'COMMENV_N11'   : {$pf = array(  324.000,  746.640); break;}
			case 'COMMENV_N12'   : {$pf = array(  342.000,  792.000); break;}
			case 'COMMENV_N14'   : {$pf = array(  360.000,  828.000); break;}
			//   - Catalogue Envelopes
			case 'CATENV_N1'     : {$pf = array(  432.000,  648.000); break;}
			case 'CATENV_N1_3/4' : {$pf = array(  468.000,  684.000); break;}
			case 'CATENV_N2'     : {$pf = array(  468.000,  720.000); break;}
			case 'CATENV_N3'     : {$pf = array(  504.000,  720.000); break;}
			case 'CATENV_N6'     : {$pf = array(  540.000,  756.000); break;}
			case 'CATENV_N7'     : {$pf = array(  576.000,  792.000); break;}
			case 'CATENV_N8'     : {$pf = array(  594.000,  810.000); break;}
			case 'CATENV_N9_1/2' : {$pf = array(  612.000,  756.000); break;}
			case 'CATENV_N9_3/4' : {$pf = array(  630.000,  810.000); break;}
			case 'CATENV_N10_1/2': {$pf = array(  648.000,  864.000); break;}
			case 'CATENV_N12_1/2': {$pf = array(  684.000,  900.000); break;}
			case 'CATENV_N13_1/2': {$pf = array(  720.000,  936.000); break;}
			case 'CATENV_N14_1/4': {$pf = array(  810.000,  882.000); break;}
			case 'CATENV_N14_1/2': {$pf = array(  828.000, 1044.000); break;}
			// Japanese (JIS P 0138-61) Standard B-Series
			case 'JIS_B0' : {$pf = array( 2919.685, 4127.244); break;}
			case 'JIS_B1' : {$pf = array( 2063.622, 2919.685); break;}
			case 'JIS_B2' : {$pf = array( 1459.843, 2063.622); break;}
			case 'JIS_B3' : {$pf = array( 1031.811, 1459.843); break;}
			case 'JIS_B4' : {$pf = array(  728.504, 1031.811); break;}
			case 'JIS_B5' : {$pf = array(  515.906,  728.504); break;}
			case 'JIS_B6' : {$pf = array(  362.835,  515.906); break;}
			case 'JIS_B7' : {$pf = array(  257.953,  362.835); break;}
			case 'JIS_B8' : {$pf = array(  181.417,  257.953); break;}
			case 'JIS_B9' : {$pf = array(  127.559,  181.417); break;}
			case 'JIS_B10': {$pf = array(   90.709,  127.559); break;}
			case 'JIS_B11': {$pf = array(   62.362,   90.709); break;}
			case 'JIS_B12': {$pf = array(   45.354,   62.362); break;}
			// PA Series
			case 'PA0' : {$pf = array( 2381.102, 3174.803,); break;}
			case 'PA1' : {$pf = array( 1587.402, 2381.102); break;}
			case 'PA2' : {$pf = array( 1190.551, 1587.402); break;}
			case 'PA3' : {$pf = array(  793.701, 1190.551); break;}
			case 'PA4' : {$pf = array(  595.276,  793.701); break;}
			case 'PA5' : {$pf = array(  396.850,  595.276); break;}
			case 'PA6' : {$pf = array(  297.638,  396.850); break;}
			case 'PA7' : {$pf = array(  198.425,  297.638); break;}
			case 'PA8' : {$pf = array(  147.402,  198.425); break;}
			case 'PA9' : {$pf = array(   99.213,  147.402); break;}
			case 'PA10': {$pf = array(   73.701,   99.213); break;}
			// Standard Photographic Print Sizes
			case 'PASSPORT_PHOTO': {$pf = array(   99.213,  127.559); break;}
			case 'E'   : {$pf = array(  233.858,  340.157); break;}
			case 'L':
			case '3R'  : {$pf = array(  252.283,  360.000); break;}
			case 'KG':
			case '4R'  : {$pf = array(  289.134,  430.866); break;}
			case '4D'  : {$pf = array(  340.157,  430.866); break;}
			case '2L':
			case '5R'  : {$pf = array(  360.000,  504.567); break;}
			case '8P':
			case '6R'  : {$pf = array(  430.866,  575.433); break;}
			case '6P':
			case '8R'  : {$pf = array(  575.433,  720.000); break;}
			case '6PW':
			case 'S8R' : {$pf = array(  575.433,  864.567); break;}
			case '4P':
			case '10R' : {$pf = array(  720.000,  864.567); break;}
			case '4PW':
			case 'S10R': {$pf = array(  720.000, 1080.000); break;}
			case '11R' : {$pf = array(  790.866, 1009.134); break;}
			case 'S11R': {$pf = array(  790.866, 1224.567); break;}
			case '12R' : {$pf = array(  864.567, 1080.000); break;}
			case 'S12R': {$pf = array(  864.567, 1292.598); break;}
			// Common Newspaper Sizes
			case 'NEWSPAPER_BROADSHEET': {$pf = array( 2125.984, 1700.787); break;}
			case 'NEWSPAPER_BERLINER'  : {$pf = array( 1332.283,  892.913); break;}
			case 'NEWSPAPER_TABLOID':
			case 'NEWSPAPER_COMPACT'   : {$pf = array( 1218.898,  793.701); break;}
			// Business Cards
			case 'CREDIT_CARD':
			case 'BUSINESS_CARD':
			case 'BUSINESS_CARD_ISO7810': {$pf = array(  153.014,  242.646); break;}
			case 'BUSINESS_CARD_ISO216' : {$pf = array(  147.402,  209.764); break;}
			case 'BUSINESS_CARD_IT':
			case 'BUSINESS_CARD_UK':
			case 'BUSINESS_CARD_FR':
			case 'BUSINESS_CARD_DE':
			case 'BUSINESS_CARD_ES'     : {$pf = array(  155.906,  240.945); break;}
			case 'BUSINESS_CARD_CA':
			case 'BUSINESS_CARD_US'     : {$pf = array(  144.567,  252.283); break;}
			case 'BUSINESS_CARD_JP'     : {$pf = array(  155.906,  257.953); break;}
			case 'BUSINESS_CARD_HK'     : {$pf = array(  153.071,  255.118); break;}
			case 'BUSINESS_CARD_AU':
			case 'BUSINESS_CARD_DK':
			case 'BUSINESS_CARD_SE'     : {$pf = array(  155.906,  255.118); break;}
			case 'BUSINESS_CARD_RU':
			case 'BUSINESS_CARD_CZ':
			case 'BUSINESS_CARD_FI':
			case 'BUSINESS_CARD_HU':
			case 'BUSINESS_CARD_IL'     : {$pf = array(  141.732,  255.118); break;}
			// Billboards
			case '4SHEET' : {$pf = array( 2880.000, 4320.000); break;}
			case '6SHEET' : {$pf = array( 3401.575, 5102.362); break;}
			case '12SHEET': {$pf = array( 8640.000, 4320.000); break;}
			case '16SHEET': {$pf = array( 5760.000, 8640.000); break;}
			case '32SHEET': {$pf = array(11520.000, 8640.000); break;}
			case '48SHEET': {$pf = array(17280.000, 8640.000); break;}
			case '64SHEET': {$pf = array(23040.000, 8640.000); break;}
			case '96SHEET': {$pf = array(34560.000, 8640.000); break;}
			// Old European Sizes
			//   - Old Imperial English Sizes
			case 'EN_EMPEROR'          : {$pf = array( 3456.000, 5184.000); break;}
			case 'EN_ANTIQUARIAN'      : {$pf = array( 2232.000, 3816.000); break;}
			case 'EN_GRAND_EAGLE'      : {$pf = array( 2070.000, 3024.000); break;}
			case 'EN_DOUBLE_ELEPHANT'  : {$pf = array( 1926.000, 2880.000); break;}
			case 'EN_ATLAS'            : {$pf = array( 1872.000, 2448.000); break;}
			case 'EN_COLOMBIER'        : {$pf = array( 1692.000, 2484.000); break;}
			case 'EN_ELEPHANT'         : {$pf = array( 1656.000, 2016.000); break;}
			case 'EN_DOUBLE_DEMY'      : {$pf = array( 1620.000, 2556.000); break;}
			case 'EN_IMPERIAL'         : {$pf = array( 1584.000, 2160.000); break;}
			case 'EN_PRINCESS'         : {$pf = array( 1548.000, 2016.000); break;}
			case 'EN_CARTRIDGE'        : {$pf = array( 1512.000, 1872.000); break;}
			case 'EN_DOUBLE_LARGE_POST': {$pf = array( 1512.000, 2376.000); break;}
			case 'EN_ROYAL'            : {$pf = array( 1440.000, 1800.000); break;}
			case 'EN_SHEET':
			case 'EN_HALF_POST'        : {$pf = array( 1404.000, 1692.000); break;}
			case 'EN_SUPER_ROYAL'      : {$pf = array( 1368.000, 1944.000); break;}
			case 'EN_DOUBLE_POST'      : {$pf = array( 1368.000, 2196.000); break;}
			case 'EN_MEDIUM'           : {$pf = array( 1260.000, 1656.000); break;}
			case 'EN_DEMY'             : {$pf = array( 1260.000, 1620.000); break;}
			case 'EN_LARGE_POST'       : {$pf = array( 1188.000, 1512.000); break;}
			case 'EN_COPY_DRAUGHT'     : {$pf = array( 1152.000, 1440.000); break;}
			case 'EN_POST'             : {$pf = array( 1116.000, 1386.000); break;}
			case 'EN_CROWN'            : {$pf = array( 1080.000, 1440.000); break;}
			case 'EN_PINCHED_POST'     : {$pf = array( 1062.000, 1332.000); break;}
			case 'EN_BRIEF'            : {$pf = array(  972.000, 1152.000); break;}
			case 'EN_FOOLSCAP'         : {$pf = array(  972.000, 1224.000); break;}
			case 'EN_SMALL_FOOLSCAP'   : {$pf = array(  954.000, 1188.000); break;}
			case 'EN_POTT'             : {$pf = array(  900.000, 1080.000); break;}
			//   - Old Imperial Belgian Sizes
			case 'BE_GRAND_AIGLE' : {$pf = array( 1984.252, 2948.031); break;}
			case 'BE_COLOMBIER'   : {$pf = array( 1757.480, 2409.449); break;}
			case 'BE_DOUBLE_CARRE': {$pf = array( 1757.480, 2607.874); break;}
			case 'BE_ELEPHANT'    : {$pf = array( 1746.142, 2182.677); break;}
			case 'BE_PETIT_AIGLE' : {$pf = array( 1700.787, 2381.102); break;}
			case 'BE_GRAND_JESUS' : {$pf = array( 1559.055, 2069.291); break;}
			case 'BE_JESUS'       : {$pf = array( 1530.709, 2069.291); break;}
			case 'BE_RAISIN'      : {$pf = array( 1417.323, 1842.520); break;}
			case 'BE_GRAND_MEDIAN': {$pf = array( 1303.937, 1714.961); break;}
			case 'BE_DOUBLE_POSTE': {$pf = array( 1233.071, 1601.575); break;}
			case 'BE_COQUILLE'    : {$pf = array( 1218.898, 1587.402); break;}
			case 'BE_PETIT_MEDIAN': {$pf = array( 1176.378, 1502.362); break;}
			case 'BE_RUCHE'       : {$pf = array( 1020.472, 1303.937); break;}
			case 'BE_PROPATRIA'   : {$pf = array(  977.953, 1218.898); break;}
			case 'BE_LYS'         : {$pf = array(  898.583, 1125.354); break;}
			case 'BE_POT'         : {$pf = array(  870.236, 1088.504); break;}
			case 'BE_ROSETTE'     : {$pf = array(  765.354,  983.622); break;}
			//   - Old Imperial French Sizes
			case 'FR_UNIVERS'          : {$pf = array( 2834.646, 3685.039); break;}
			case 'FR_DOUBLE_COLOMBIER' : {$pf = array( 2551.181, 3571.654); break;}
			case 'FR_GRANDE_MONDE'     : {$pf = array( 2551.181, 3571.654); break;}
			case 'FR_DOUBLE_SOLEIL'    : {$pf = array( 2267.717, 3401.575); break;}
			case 'FR_DOUBLE_JESUS'     : {$pf = array( 2154.331, 3174.803); break;}
			case 'FR_GRAND_AIGLE'      : {$pf = array( 2125.984, 3004.724); break;}
			case 'FR_PETIT_AIGLE'      : {$pf = array( 1984.252, 2664.567); break;}
			case 'FR_DOUBLE_RAISIN'    : {$pf = array( 1842.520, 2834.646); break;}
			case 'FR_JOURNAL'          : {$pf = array( 1842.520, 2664.567); break;}
			case 'FR_COLOMBIER_AFFICHE': {$pf = array( 1785.827, 2551.181); break;}
			case 'FR_DOUBLE_CAVALIER'  : {$pf = array( 1757.480, 2607.874); break;}
			case 'FR_CLOCHE'           : {$pf = array( 1700.787, 2267.717); break;}
			case 'FR_SOLEIL'           : {$pf = array( 1700.787, 2267.717); break;}
			case 'FR_DOUBLE_CARRE'     : {$pf = array( 1587.402, 2551.181); break;}
			case 'FR_DOUBLE_COQUILLE'  : {$pf = array( 1587.402, 2494.488); break;}
			case 'FR_JESUS'            : {$pf = array( 1587.402, 2154.331); break;}
			case 'FR_RAISIN'           : {$pf = array( 1417.323, 1842.520); break;}
			case 'FR_CAVALIER'         : {$pf = array( 1303.937, 1757.480); break;}
			case 'FR_DOUBLE_COURONNE'  : {$pf = array( 1303.937, 2040.945); break;}
			case 'FR_CARRE'            : {$pf = array( 1275.591, 1587.402); break;}
			case 'FR_COQUILLE'         : {$pf = array( 1247.244, 1587.402); break;}
			case 'FR_DOUBLE_TELLIERE'  : {$pf = array( 1247.244, 1927.559); break;}
			case 'FR_DOUBLE_CLOCHE'    : {$pf = array( 1133.858, 1700.787); break;}
			case 'FR_DOUBLE_POT'       : {$pf = array( 1133.858, 1757.480); break;}
			case 'FR_ECU'              : {$pf = array( 1133.858, 1474.016); break;}
			case 'FR_COURONNE'         : {$pf = array( 1020.472, 1303.937); break;}
			case 'FR_TELLIERE'         : {$pf = array(  963.780, 1247.244); break;}
			case 'FR_POT'              : {$pf = array(  878.740, 1133.858); break;}
			// DEFAULT ISO A4
			default: {$pf = array(  595.276,  841.890); break;}
		}
		return $pf;
	}

	/**
	 * Change the format of the current page
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() documentation or an array of two numners (width, height) or an array containing the following measures and options:<ul>
	 * <li>['format'] = page format name (one of the above);</li>
	 * <li>['Rotate'] : The number of degrees by which the page shall be rotated clockwise when displayed or printed. The value shall be a multiple of 90.</li>
	 * <li>['PZ'] : The page's preferred zoom (magnification) factor.</li>
	 * <li>['MediaBox'] : the boundaries of the physical medium on which the page shall be displayed or printed:</li>
	 * <li>['MediaBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['MediaBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['MediaBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['MediaBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['CropBox'] : the visible region of default user space:</li>
	 * <li>['CropBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['CropBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['CropBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['CropBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['BleedBox'] : the region to which the contents of the page shall be clipped when output in a production environment:</li>
	 * <li>['BleedBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['BleedBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['BleedBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['BleedBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['TrimBox'] : the intended dimensions of the finished page after trimming:</li>
	 * <li>['TrimBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['TrimBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['TrimBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['TrimBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['ArtBox'] : the extent of the page's meaningful content:</li>
	 * <li>['ArtBox']['llx'] : lower-left x coordinate in points</li>
	 * <li>['ArtBox']['lly'] : lower-left y coordinate in points</li>
	 * <li>['ArtBox']['urx'] : upper-right x coordinate in points</li>
	 * <li>['ArtBox']['ury'] : upper-right y coordinate in points</li>
	 * <li>['BoxColorInfo'] :specify the colours and other visual characteristics that should be used in displaying guidelines on the screen for each of the possible page boundaries other than the MediaBox:</li>
	 * <li>['BoxColorInfo'][BOXTYPE]['C'] : an array of three numbers in the range 0-255, representing the components in the DeviceRGB colour space.</li>
	 * <li>['BoxColorInfo'][BOXTYPE]['W'] : the guideline width in default user units</li>
	 * <li>['BoxColorInfo'][BOXTYPE]['S'] : the guideline style: S = Solid; D = Dashed</li>
	 * <li>['BoxColorInfo'][BOXTYPE]['D'] : dash array defining a pattern of dashes and gaps to be used in drawing dashed guidelines</li>
	 * <li>['trans'] : the style and duration of the visual transition to use when moving from another page to the given page during a presentation</li>
	 * <li>['trans']['Dur'] : The page's display duration (also called its advance timing): the maximum length of time, in seconds, that the page shall be displayed during presentations before the viewer application shall automatically advance to the next page.</li>
	 * <li>['trans']['S'] : transition style : Split, Blinds, Box, Wipe, Dissolve, Glitter, R, Fly, Push, Cover, Uncover, Fade</li>
	 * <li>['trans']['D'] : The duration of the transition effect, in seconds.</li>
	 * <li>['trans']['Dm'] : (Split and Blinds transition styles only) The dimension in which the specified transition effect shall occur: H = Horizontal, V = Vertical. Default value: H.</li>
	 * <li>['trans']['M'] : (Split, Box and Fly transition styles only) The direction of motion for the specified transition effect: I = Inward from the edges of the page, O = Outward from the center of the pageDefault value: I.</li>
	 * <li>['trans']['Di'] : (Wipe, Glitter, Fly, Cover, Uncover and Push transition styles only) The direction in which the specified transition effect shall moves, expressed in degrees counterclockwise starting from a left-to-right direction. If the value is a number, it shall be one of: 0 = Left to right, 90 = Bottom to top (Wipe only), 180 = Right to left (Wipe only), 270 = Top to bottom, 315 = Top-left to bottom-right (Glitter only). If the value is a name, it shall be None, which is relevant only for the Fly transition when the value of SS is not 1.0. Default value: 0.</li>
	 * <li>['trans']['SS'] : (Fly transition style only) The starting or ending scale at which the changes shall be drawn. If M specifies an inward transition, the scale of the changes drawn shall progress from SS to 1.0 over the course of the transition. If M specifies an outward transition, the scale of the changes drawn shall progress from 1.0 to SS over the course of the transition. Default: 1.0.</li>
	 * <li>['trans']['B'] : (Fly transition style only) If true, the area that shall be flown in is rectangular and opaque. Default: false.</li>
	 * </ul>
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul>
	 * <li>P or Portrait (default)</li>
	 * <li>L or Landscape</li>
	 * <li>'' (empty string) for automatic orientation</li>
	 * </ul>
	 * @protected
	 * @since 3.0.015 (2008-06-06)
	 * @see getPageSizeFromFormat()
	 */
	protected function setPageFormat($format, $orientation='P') {
		if (!empty($format) AND isset($this->pagedim[$this->page])) {
			// remove inherited values
			unset($this->pagedim[$this->page]);
		}
		if (is_string($format)) {
			// get page measures from format name
			$pf = $this->getPageSizeFromFormat($format);
			$this->fwPt = $pf[0];
			$this->fhPt = $pf[1];
		} else {
			// the boundaries of the physical medium on which the page shall be displayed or printed
			if (isset($format['MediaBox'])) {
				$this->setPageBoxes($this->page, 'MediaBox', $format['MediaBox']['llx'], $format['MediaBox']['lly'], $format['MediaBox']['urx'], $format['MediaBox']['ury'], false);
				$this->fwPt = (($format['MediaBox']['urx'] - $format['MediaBox']['llx']) * $this->k);
				$this->fhPt = (($format['MediaBox']['ury'] - $format['MediaBox']['lly']) * $this->k);
			} else {
				if (isset($format[0]) AND is_numeric($format[0]) AND isset($format[1]) AND is_numeric($format[1])) {
					$pf = array(($format[0] * $this->k), ($format[1] * $this->k));
				} else {
					if (!isset($format['format'])) {
						// default value
						$format['format'] = 'A4';
					}
					$pf = $this->getPageSizeFromFormat($format['format']);
				}
				$this->fwPt = $pf[0];
				$this->fhPt = $pf[1];
				$this->setPageBoxes($this->page, 'MediaBox', 0, 0, $this->fwPt, $this->fhPt, true);
			}
			// the visible region of default user space
			if (isset($format['CropBox'])) {
				$this->setPageBoxes($this->page, 'CropBox', $format['CropBox']['llx'], $format['CropBox']['lly'], $format['CropBox']['urx'], $format['CropBox']['ury'], false);
			}
			// the region to which the contents of the page shall be clipped when output in a production environment
			if (isset($format['BleedBox'])) {
				$this->setPageBoxes($this->page, 'BleedBox', $format['BleedBox']['llx'], $format['BleedBox']['lly'], $format['BleedBox']['urx'], $format['BleedBox']['ury'], false);
			}
			// the intended dimensions of the finished page after trimming
			if (isset($format['TrimBox'])) {
				$this->setPageBoxes($this->page, 'TrimBox', $format['TrimBox']['llx'], $format['TrimBox']['lly'], $format['TrimBox']['urx'], $format['TrimBox']['ury'], false);
			}
			// the page's meaningful content (including potential white space)
			if (isset($format['ArtBox'])) {
				$this->setPageBoxes($this->page, 'ArtBox', $format['ArtBox']['llx'], $format['ArtBox']['lly'], $format['ArtBox']['urx'], $format['ArtBox']['ury'], false);
			}
			// specify the colours and other visual characteristics that should be used in displaying guidelines on the screen for the various page boundaries
			if (isset($format['BoxColorInfo'])) {
				$this->pagedim[$this->page]['BoxColorInfo'] = $format['BoxColorInfo'];
			}
			if (isset($format['Rotate']) AND (($format['Rotate'] % 90) == 0)) {
				// The number of degrees by which the page shall be rotated clockwise when displayed or printed. The value shall be a multiple of 90.
				$this->pagedim[$this->page]['Rotate'] = intval($format['Rotate']);
			}
			if (isset($format['PZ'])) {
				// The page's preferred zoom (magnification) factor
				$this->pagedim[$this->page]['PZ'] = floatval($format['PZ']);
			}
			if (isset($format['trans'])) {
				// The style and duration of the visual transition to use when moving from another page to the given page during a presentation
				if (isset($format['trans']['Dur'])) {
					// The page's display duration
					$this->pagedim[$this->page]['trans']['Dur'] = floatval($format['trans']['Dur']);
				}
				$stansition_styles = array('Split', 'Blinds', 'Box', 'Wipe', 'Dissolve', 'Glitter', 'R', 'Fly', 'Push', 'Cover', 'Uncover', 'Fade');
				if (isset($format['trans']['S']) AND in_array($format['trans']['S'], $stansition_styles)) {
					// The transition style that shall be used when moving to this page from another during a presentation
					$this->pagedim[$this->page]['trans']['S'] = $format['trans']['S'];
					$valid_effect = array('Split', 'Blinds');
					$valid_vals = array('H', 'V');
					if (isset($format['trans']['Dm']) AND in_array($format['trans']['S'], $valid_effect) AND in_array($format['trans']['Dm'], $valid_vals)) {
						$this->pagedim[$this->page]['trans']['Dm'] = $format['trans']['Dm'];
					}
					$valid_effect = array('Split', 'Box', 'Fly');
					$valid_vals = array('I', 'O');
					if (isset($format['trans']['M']) AND in_array($format['trans']['S'], $valid_effect) AND in_array($format['trans']['M'], $valid_vals)) {
						$this->pagedim[$this->page]['trans']['M'] = $format['trans']['M'];
					}
					$valid_effect = array('Wipe', 'Glitter', 'Fly', 'Cover', 'Uncover', 'Push');
					if (isset($format['trans']['Di']) AND in_array($format['trans']['S'], $valid_effect)) {
						if (((($format['trans']['Di'] == 90) OR ($format['trans']['Di'] == 180)) AND ($format['trans']['S'] == 'Wipe'))
							OR (($format['trans']['Di'] == 315) AND ($format['trans']['S'] == 'Glitter'))
							OR (($format['trans']['Di'] == 0) OR ($format['trans']['Di'] == 270))) {
							$this->pagedim[$this->page]['trans']['Di'] = intval($format['trans']['Di']);
						}
					}
					if (isset($format['trans']['SS']) AND ($format['trans']['S'] == 'Fly')) {
						$this->pagedim[$this->page]['trans']['SS'] = floatval($format['trans']['SS']);
					}
					if (isset($format['trans']['B']) AND ($format['trans']['B'] === true) AND ($format['trans']['S'] == 'Fly')) {
						$this->pagedim[$this->page]['trans']['B'] = 'true';
					}
				} else {
					$this->pagedim[$this->page]['trans']['S'] = 'R';
				}
				if (isset($format['trans']['D'])) {
					// The duration of the transition effect, in seconds
					$this->pagedim[$this->page]['trans']['D'] = floatval($format['trans']['D']);
				} else {
					$this->pagedim[$this->page]['trans']['D'] = 1;
				}
			}
		}
		$this->setPageOrientation($orientation);
	}

	/**
	 * Set page boundaries.
	 * @param $page (int) page number
	 * @param $type (string) valid values are: <ul><li>'MediaBox' : the boundaries of the physical medium on which the page shall be displayed or printed;</li><li>'CropBox' : the visible region of default user space;</li><li>'BleedBox' : the region to which the contents of the page shall be clipped when output in a production environment;</li><li>'TrimBox' : the intended dimensions of the finished page after trimming;</li><li>'ArtBox' : the page's meaningful content (including potential white space).</li></ul>
	 * @param $llx (float) lower-left x coordinate in user units
	 * @param $lly (float) lower-left y coordinate in user units
	 * @param $urx (float) upper-right x coordinate in user units
	 * @param $ury (float) upper-right y coordinate in user units
	 * @param $points (boolean) if true uses user units as unit of measure, otherwise uses PDF points
	 * @public
	 * @since 5.0.010 (2010-05-17)
	 */
	public function setPageBoxes($page, $type, $llx, $lly, $urx, $ury, $points=false) {
		if (!isset($this->pagedim[$page])) {
			// initialize array
			$this->pagedim[$page] = array();
		}
		$pageboxes = array('MediaBox', 'CropBox', 'BleedBox', 'TrimBox', 'ArtBox');
		if (!in_array($type, $pageboxes)) {
			return;
		}
		if ($points) {
			$k = 1;
		} else {
			$k = $this->k;
		}
		$this->pagedim[$page][$type]['llx'] = ($llx * $k);
		$this->pagedim[$page][$type]['lly'] = ($lly * $k);
		$this->pagedim[$page][$type]['urx'] = ($urx * $k);
		$this->pagedim[$page][$type]['ury'] = ($ury * $k);
	}

	/**
	 * Swap X and Y coordinates of page boxes (change page boxes orientation).
	 * @param $page (int) page number
	 * @protected
	 * @since 5.0.010 (2010-05-17)
	 */
	protected function swapPageBoxCoordinates($page) {
		$pageboxes = array('MediaBox', 'CropBox', 'BleedBox', 'TrimBox', 'ArtBox');
		foreach ($pageboxes as $type) {
			// swap X and Y coordinates
			if (isset($this->pagedim[$page][$type])) {
				$tmp = $this->pagedim[$page][$type]['llx'];
				$this->pagedim[$page][$type]['llx'] = $this->pagedim[$page][$type]['lly'];
				$this->pagedim[$page][$type]['lly'] = $tmp;
				$tmp = $this->pagedim[$page][$type]['urx'];
				$this->pagedim[$page][$type]['urx'] = $this->pagedim[$page][$type]['ury'];
				$this->pagedim[$page][$type]['ury'] = $tmp;
			}
		}
	}

	/**
	 * Set page orientation.
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or Portrait (default)</li><li>L or Landscape</li><li>'' (empty string) for automatic orientation</li></ul>
	 * @param $autopagebreak (boolean) Boolean indicating if auto-page-break mode should be on or off.
	 * @param $bottommargin (float) bottom margin of the page.
	 * @public
	 * @since 3.0.015 (2008-06-06)
	 */
	public function setPageOrientation($orientation, $autopagebreak='', $bottommargin='') {
		if (!isset($this->pagedim[$this->page]['MediaBox'])) {
			// the boundaries of the physical medium on which the page shall be displayed or printed
			$this->setPageBoxes($this->page, 'MediaBox', 0, 0, $this->fwPt, $this->fhPt, true);
		}
		if (!isset($this->pagedim[$this->page]['CropBox'])) {
			// the visible region of default user space
			$this->setPageBoxes($this->page, 'CropBox', $this->pagedim[$this->page]['MediaBox']['llx'], $this->pagedim[$this->page]['MediaBox']['lly'], $this->pagedim[$this->page]['MediaBox']['urx'], $this->pagedim[$this->page]['MediaBox']['ury'], true);
		}
		if (!isset($this->pagedim[$this->page]['BleedBox'])) {
			// the region to which the contents of the page shall be clipped when output in a production environment
			$this->setPageBoxes($this->page, 'BleedBox', $this->pagedim[$this->page]['CropBox']['llx'], $this->pagedim[$this->page]['CropBox']['lly'], $this->pagedim[$this->page]['CropBox']['urx'], $this->pagedim[$this->page]['CropBox']['ury'], true);
		}
		if (!isset($this->pagedim[$this->page]['TrimBox'])) {
			// the intended dimensions of the finished page after trimming
			$this->setPageBoxes($this->page, 'TrimBox', $this->pagedim[$this->page]['CropBox']['llx'], $this->pagedim[$this->page]['CropBox']['lly'], $this->pagedim[$this->page]['CropBox']['urx'], $this->pagedim[$this->page]['CropBox']['ury'], true);
		}
		if (!isset($this->pagedim[$this->page]['ArtBox'])) {
			// the page's meaningful content (including potential white space)
			$this->setPageBoxes($this->page, 'ArtBox', $this->pagedim[$this->page]['CropBox']['llx'], $this->pagedim[$this->page]['CropBox']['lly'], $this->pagedim[$this->page]['CropBox']['urx'], $this->pagedim[$this->page]['CropBox']['ury'], true);
		}
		if (!isset($this->pagedim[$this->page]['Rotate'])) {
			// The number of degrees by which the page shall be rotated clockwise when displayed or printed. The value shall be a multiple of 90.
			$this->pagedim[$this->page]['Rotate'] = 0;
		}
		if (!isset($this->pagedim[$this->page]['PZ'])) {
			// The page's preferred zoom (magnification) factor
			$this->pagedim[$this->page]['PZ'] = 1;
		}
		if ($this->fwPt > $this->fhPt) {
			// landscape
			$default_orientation = 'L';
		} else {
			// portrait
			$default_orientation = 'P';
		}
		$valid_orientations = array('P', 'L');
		if (empty($orientation)) {
			$orientation = $default_orientation;
		} else {
			$orientation = strtoupper($orientation{0});
		}
		if (in_array($orientation, $valid_orientations) AND ($orientation != $default_orientation)) {
			$this->CurOrientation = $orientation;
			$this->wPt = $this->fhPt;
			$this->hPt = $this->fwPt;
		} else {
			$this->CurOrientation = $default_orientation;
			$this->wPt = $this->fwPt;
			$this->hPt = $this->fhPt;
		}
		if ((abs($this->pagedim[$this->page]['MediaBox']['urx'] - $this->hPt) < $this->feps) AND (abs($this->pagedim[$this->page]['MediaBox']['ury'] - $this->wPt) < $this->feps)){
			// swap X and Y coordinates (change page orientation)
			$this->swapPageBoxCoordinates($this->page);
		}
		$this->w = $this->wPt / $this->k;
		$this->h = $this->hPt / $this->k;
		if ($this->empty_string($autopagebreak)) {
			if (isset($this->AutoPageBreak)) {
				$autopagebreak = $this->AutoPageBreak;
			} else {
				$autopagebreak = true;
			}
		}
		if ($this->empty_string($bottommargin)) {
			if (isset($this->bMargin)) {
				$bottommargin = $this->bMargin;
			} else {
				// default value = 2 cm
				$bottommargin = 2 * 28.35 / $this->k;
			}
		}
		$this->SetAutoPageBreak($autopagebreak, $bottommargin);
		// store page dimensions
		$this->pagedim[$this->page]['w'] = $this->wPt;
		$this->pagedim[$this->page]['h'] = $this->hPt;
		$this->pagedim[$this->page]['wk'] = $this->w;
		$this->pagedim[$this->page]['hk'] = $this->h;
		$this->pagedim[$this->page]['tm'] = $this->tMargin;
		$this->pagedim[$this->page]['bm'] = $bottommargin;
		$this->pagedim[$this->page]['lm'] = $this->lMargin;
		$this->pagedim[$this->page]['rm'] = $this->rMargin;
		$this->pagedim[$this->page]['pb'] = $autopagebreak;
		$this->pagedim[$this->page]['or'] = $this->CurOrientation;
		$this->pagedim[$this->page]['olm'] = $this->original_lMargin;
		$this->pagedim[$this->page]['orm'] = $this->original_rMargin;
	}

	/**
	 * Set regular expression to detect withespaces or word separators.
	 * The pattern delimiter must be the forward-slash character "/".
	 * Some example patterns are:
	 * <pre>
	 * Non-Unicode or missing PCRE unicode support: "/[^\S\xa0]/"
	 * Unicode and PCRE unicode support: "/[^\S\P{Z}\xa0]/u"
	 * Unicode and PCRE unicode support in Chinese mode: "/[^\S\P{Z}\P{Lo}\xa0]/u"
	 * if PCRE unicode support is turned ON ("\P" is the negate class of "\p"):
	 * "\p{Z}" or "\p{Separator}": any kind of Unicode whitespace or invisible separator.
	 * "\p{Lo}" or "\p{Other_Letter}": a Unicode letter or ideograph that does not have lowercase and uppercase variants.
	 * "\p{Lo}" is needed for Chinese characters because are packed next to each other without spaces in between.
	 * </pre>
	 * @param $re (string) regular expression (leave empty for default).
	 * @public
	 * @since 4.6.016 (2009-06-15)
	 */
	public function setSpacesRE($re='/[^\S\xa0]/') {
		$this->re_spaces = $re;
		$re_parts = explode('/', $re);
		// get pattern parts
		$this->re_space = array();
		if (isset($re_parts[1]) AND !empty($re_parts[1])) {
			$this->re_space['p'] = $re_parts[1];
		} else {
			$this->re_space['p'] = '[\s]';
		}
		// set pattern modifiers
		if (isset($re_parts[2]) AND !empty($re_parts[2])) {
			$this->re_space['m'] = $re_parts[2];
		} else {
			$this->re_space['m'] = '';
		}
	}

	/**
	 * Enable or disable Right-To-Left language mode
	 * @param $enable (Boolean) if true enable Right-To-Left language mode.
	 * @param $resetx (Boolean) if true reset the X position on direction change.
	 * @public
	 * @since 2.0.000 (2008-01-03)
	 */
	public function setRTL($enable, $resetx=true) {
		$enable = $enable ? true : false;
		$resetx = ($resetx AND ($enable != $this->rtl));
		$this->rtl = $enable;
		$this->tmprtl = false;
		if ($resetx) {
			$this->Ln(0);
		}
	}

	/**
	 * Return the RTL status
	 * @return boolean
	 * @public
	 * @since 4.0.012 (2008-07-24)
	 */
	public function getRTL() {
		return $this->rtl;
	}

	/**
	 * Force temporary RTL language direction
	 * @param $mode (mixed) can be false, 'L' for LTR or 'R' for RTL
	 * @public
	 * @since 2.1.000 (2008-01-09)
	 */
	public function setTempRTL($mode) {
		$newmode = false;
		switch (strtoupper($mode)) {
			case 'LTR':
			case 'L': {
				if ($this->rtl) {
					$newmode = 'L';
				}
				break;
			}
			case 'RTL':
			case 'R': {
				if (!$this->rtl) {
					$newmode = 'R';
				}
				break;
			}
			case false:
			default: {
				$newmode = false;
				break;
			}
		}
		$this->tmprtl = $newmode;
	}

	/**
	 * Return the current temporary RTL status
	 * @return boolean
	 * @public
	 * @since 4.8.014 (2009-11-04)
	 */
	public function isRTLTextDir() {
		return ($this->rtl OR ($this->tmprtl == 'R'));
	}

	/**
	 * Set the last cell height.
	 * @param $h (float) cell height.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.53.0.TC034
	 */
	public function setLastH($h) {
		$this->lasth = $h;
	}

	/**
	 * Reset the last cell height.
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 */
	public function resetLastH() {
		$this->lasth = ($this->FontSize * $this->cell_height_ratio) + $this->cell_padding['T'] + $this->cell_padding['B'];
	}

	/**
	 * Get the last cell height.
	 * @return last cell height
	 * @public
	 * @since 4.0.017 (2008-08-05)
	 */
	public function getLastH() {
		return $this->lasth;
	}

	/**
	 * Set the adjusting factor to convert pixels to user units.
	 * @param $scale (float) adjusting factor to convert pixels to user units.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 */
	public function setImageScale($scale) {
		$this->imgscale = $scale;
	}

	/**
	 * Returns the adjusting factor to convert pixels to user units.
	 * @return float adjusting factor to convert pixels to user units.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 */
	public function getImageScale() {
		return $this->imgscale;
	}

	/**
	 * Returns an array of page dimensions:
	 * <ul><li>$this->pagedim[$this->page]['w'] = page width in points</li><li>$this->pagedim[$this->page]['h'] = height in points</li><li>$this->pagedim[$this->page]['wk'] = page width in user units</li><li>$this->pagedim[$this->page]['hk'] = page height in user units</li><li>$this->pagedim[$this->page]['tm'] = top margin</li><li>$this->pagedim[$this->page]['bm'] = bottom margin</li><li>$this->pagedim[$this->page]['lm'] = left margin</li><li>$this->pagedim[$this->page]['rm'] = right margin</li><li>$this->pagedim[$this->page]['pb'] = auto page break</li><li>$this->pagedim[$this->page]['or'] = page orientation</li><li>$this->pagedim[$this->page]['olm'] = original left margin</li><li>$this->pagedim[$this->page]['orm'] = original right margin</li><li>$this->pagedim[$this->page]['Rotate'] = The number of degrees by which the page shall be rotated clockwise when displayed or printed. The value shall be a multiple of 90.</li><li>$this->pagedim[$this->page]['PZ'] = The page's preferred zoom (magnification) factor.</li><li>$this->pagedim[$this->page]['trans'] : the style and duration of the visual transition to use when moving from another page to the given page during a presentation<ul><li>$this->pagedim[$this->page]['trans']['Dur'] = The page's display duration (also called its advance timing): the maximum length of time, in seconds, that the page shall be displayed during presentations before the viewer application shall automatically advance to the next page.</li><li>$this->pagedim[$this->page]['trans']['S'] = transition style : Split, Blinds, Box, Wipe, Dissolve, Glitter, R, Fly, Push, Cover, Uncover, Fade</li><li>$this->pagedim[$this->page]['trans']['D'] = The duration of the transition effect, in seconds.</li><li>$this->pagedim[$this->page]['trans']['Dm'] = (Split and Blinds transition styles only) The dimension in which the specified transition effect shall occur: H = Horizontal, V = Vertical. Default value: H.</li><li>$this->pagedim[$this->page]['trans']['M'] = (Split, Box and Fly transition styles only) The direction of motion for the specified transition effect: I = Inward from the edges of the page, O = Outward from the center of the pageDefault value: I.</li><li>$this->pagedim[$this->page]['trans']['Di'] = (Wipe, Glitter, Fly, Cover, Uncover and Push transition styles only) The direction in which the specified transition effect shall moves, expressed in degrees counterclockwise starting from a left-to-right direction. If the value is a number, it shall be one of: 0 = Left to right, 90 = Bottom to top (Wipe only), 180 = Right to left (Wipe only), 270 = Top to bottom, 315 = Top-left to bottom-right (Glitter only). If the value is a name, it shall be None, which is relevant only for the Fly transition when the value of SS is not 1.0. Default value: 0.</li><li>$this->pagedim[$this->page]['trans']['SS'] = (Fly transition style only) The starting or ending scale at which the changes shall be drawn. If M specifies an inward transition, the scale of the changes drawn shall progress from SS to 1.0 over the course of the transition. If M specifies an outward transition, the scale of the changes drawn shall progress from 1.0 to SS over the course of the transition. Default: 1.0. </li><li>$this->pagedim[$this->page]['trans']['B'] = (Fly transition style only) If true, the area that shall be flown in is rectangular and opaque. Default: false.</li></ul></li><li>$this->pagedim[$this->page]['MediaBox'] : the boundaries of the physical medium on which the page shall be displayed or printed<ul><li>$this->pagedim[$this->page]['MediaBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['MediaBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['MediaBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['MediaBox']['ury'] = upper-right y coordinate in points</li></ul></li><li>$this->pagedim[$this->page]['CropBox'] : the visible region of default user space<ul><li>$this->pagedim[$this->page]['CropBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['CropBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['CropBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['CropBox']['ury'] = upper-right y coordinate in points</li></ul></li><li>$this->pagedim[$this->page]['BleedBox'] : the region to which the contents of the page shall be clipped when output in a production environment<ul><li>$this->pagedim[$this->page]['BleedBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['BleedBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['BleedBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['BleedBox']['ury'] = upper-right y coordinate in points</li></ul></li><li>$this->pagedim[$this->page]['TrimBox'] : the intended dimensions of the finished page after trimming<ul><li>$this->pagedim[$this->page]['TrimBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['TrimBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['TrimBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['TrimBox']['ury'] = upper-right y coordinate in points</li></ul></li><li>$this->pagedim[$this->page]['ArtBox'] : the extent of the page's meaningful content<ul><li>$this->pagedim[$this->page]['ArtBox']['llx'] = lower-left x coordinate in points</li><li>$this->pagedim[$this->page]['ArtBox']['lly'] = lower-left y coordinate in points</li><li>$this->pagedim[$this->page]['ArtBox']['urx'] = upper-right x coordinate in points</li><li>$this->pagedim[$this->page]['ArtBox']['ury'] = upper-right y coordinate in points</li></ul></li></ul>
	 * @param $pagenum (int) page number (empty = current page)
	 * @return array of page dimensions.
	 * @author Nicola Asuni
	 * @public
	 * @since 4.5.027 (2009-03-16)
	 */
	public function getPageDimensions($pagenum='') {
		if (empty($pagenum)) {
			$pagenum = $this->page;
		}
		return $this->pagedim[$pagenum];
	}

	/**
	 * Returns the page width in units.
	 * @param $pagenum (int) page number (empty = current page)
	 * @return int page width.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 * @see getPageDimensions()
	 */
	public function getPageWidth($pagenum='') {
		if (empty($pagenum)) {
			return $this->w;
		}
		return $this->pagedim[$pagenum]['w'];
	}

	/**
	 * Returns the page height in units.
	 * @param $pagenum (int) page number (empty = current page)
	 * @return int page height.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 * @see getPageDimensions()
	 */
	public function getPageHeight($pagenum='') {
		if (empty($pagenum)) {
			return $this->h;
		}
		return $this->pagedim[$pagenum]['h'];
	}

	/**
	 * Returns the page break margin.
	 * @param $pagenum (int) page number (empty = current page)
	 * @return int page break margin.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 * @see getPageDimensions()
	 */
	public function getBreakMargin($pagenum='') {
		if (empty($pagenum)) {
			return $this->bMargin;
		}
		return $this->pagedim[$pagenum]['bm'];
	}

	/**
	 * Returns the scale factor (number of points in user unit).
	 * @return int scale factor.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.5.2
	 */
	public function getScaleFactor() {
		return $this->k;
	}

	/**
	 * Defines the left, top and right margins.
	 * @param $left (float) Left margin.
	 * @param $top (float) Top margin.
	 * @param $right (float) Right margin. Default value is the left one.
	 * @param $keepmargins (boolean) if true overwrites the default page margins
	 * @public
	 * @since 1.0
	 * @see SetLeftMargin(), SetTopMargin(), SetRightMargin(), SetAutoPageBreak()
	 */
	public function SetMargins($left, $top, $right=-1, $keepmargins=false) {
		//Set left, top and right margins
		$this->lMargin = $left;
		$this->tMargin = $top;
		if ($right == -1) {
			$right = $left;
		}
		$this->rMargin = $right;
		if ($keepmargins) {
			// overwrite original values
			$this->original_lMargin = $this->lMargin;
			$this->original_rMargin = $this->rMargin;
		}
	}

	/**
	 * Defines the left margin. The method can be called before creating the first page. If the current abscissa gets out of page, it is brought back to the margin.
	 * @param $margin (float) The margin.
	 * @public
	 * @since 1.4
	 * @see SetTopMargin(), SetRightMargin(), SetAutoPageBreak(), SetMargins()
	 */
	public function SetLeftMargin($margin) {
		//Set left margin
		$this->lMargin = $margin;
		if (($this->page > 0) AND ($this->x < $margin)) {
			$this->x = $margin;
		}
	}

	/**
	 * Defines the top margin. The method can be called before creating the first page.
	 * @param $margin (float) The margin.
	 * @public
	 * @since 1.5
	 * @see SetLeftMargin(), SetRightMargin(), SetAutoPageBreak(), SetMargins()
	 */
	public function SetTopMargin($margin) {
		//Set top margin
		$this->tMargin = $margin;
		if (($this->page > 0) AND ($this->y < $margin)) {
			$this->y = $margin;
		}
	}

	/**
	 * Defines the right margin. The method can be called before creating the first page.
	 * @param $margin (float) The margin.
	 * @public
	 * @since 1.5
	 * @see SetLeftMargin(), SetTopMargin(), SetAutoPageBreak(), SetMargins()
	 */
	public function SetRightMargin($margin) {
		$this->rMargin = $margin;
		if (($this->page > 0) AND ($this->x > ($this->w - $margin))) {
			$this->x = $this->w - $margin;
		}
	}

	/**
	 * Set the same internal Cell padding for top, right, bottom, left-
	 * @param $pad (float) internal padding.
	 * @public
	 * @since 2.1.000 (2008-01-09)
	 * @see getCellPaddings(), setCellPaddings()
	 */
	public function SetCellPadding($pad) {
		if ($pad >= 0) {
			$this->cell_padding['L'] = $pad;
			$this->cell_padding['T'] = $pad;
			$this->cell_padding['R'] = $pad;
			$this->cell_padding['B'] = $pad;
		}
	}

	/**
	 * Set the internal Cell paddings.
	 * @param $left (float) left padding
	 * @param $top (float) top padding
	 * @param $right (float) right padding
	 * @param $bottom (float) bottom padding
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 * @see getCellPaddings(), SetCellPadding()
	 */
	public function setCellPaddings($left='', $top='', $right='', $bottom='') {
		if (($left !== '') AND ($left >= 0)) {
			$this->cell_padding['L'] = $left;
		}
		if (($top !== '') AND ($top >= 0)) {
			$this->cell_padding['T'] = $top;
		}
		if (($right !== '') AND ($right >= 0)) {
			$this->cell_padding['R'] = $right;
		}
		if (($bottom !== '') AND ($bottom >= 0)) {
			$this->cell_padding['B'] = $bottom;
		}
	}

	/**
	 * Get the internal Cell padding array.
	 * @return array of padding values
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 * @see setCellPaddings(), SetCellPadding()
	 */
	public function getCellPaddings() {
		return $this->cell_padding;
	}

	/**
	 * Set the internal Cell margins.
	 * @param $left (float) left margin
	 * @param $top (float) top margin
	 * @param $right (float) right margin
	 * @param $bottom (float) bottom margin
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 * @see getCellMargins()
	 */
	public function setCellMargins($left='', $top='', $right='', $bottom='') {
		if (($left !== '') AND ($left >= 0)) {
			$this->cell_margin['L'] = $left;
		}
		if (($top !== '') AND ($top >= 0)) {
			$this->cell_margin['T'] = $top;
		}
		if (($right !== '') AND ($right >= 0)) {
			$this->cell_margin['R'] = $right;
		}
		if (($bottom !== '') AND ($bottom >= 0)) {
			$this->cell_margin['B'] = $bottom;
		}
	}

	/**
	 * Get the internal Cell margin array.
	 * @return array of margin values
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 * @see setCellMargins()
	 */
	public function getCellMargins() {
		return $this->cell_margin;
	}

	/**
	 * Adjust the internal Cell padding array to take account of the line width.
	 * @param $brd (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @return array of adjustments
	 * @public
	 * @since 5.9.000 (2010-10-03)
	 */
	protected function adjustCellPadding($brd=0) {
		if (empty($brd)) {
			return;
		}
		if (is_string($brd)) {
			// convert string to array
			$slen = strlen($brd);
			$newbrd = array();
			for ($i = 0; $i < $slen; ++$i) {
				$newbrd[$brd[$i]] = true;
			}
			$brd = $newbrd;
		} elseif (($brd === 1) OR ($brd === true) OR (is_numeric($brd) AND (intval($brd) > 0))) {
			$brd = array('LRTB' => true);
		}
		if (!is_array($brd)) {
			return;
		}
		// store current cell padding
		$cp = $this->cell_padding;
		// select border mode
		if (isset($brd['mode'])) {
			$mode = $brd['mode'];
			unset($brd['mode']);
		} else {
			$mode = 'normal';
		}
		// process borders
		foreach ($brd as $border => $style) {
			$line_width = $this->LineWidth;
			if (is_array($style) AND isset($style['width'])) {
				// get border width
				$line_width = $style['width'];
			}
			$adj = 0; // line width inside the cell
			switch ($mode) {
				case 'ext': {
					$adj = 0;
					break;
				}
				case 'int': {
					$adj = $line_width;
					break;
				}
				case 'normal':
				default: {
					$adj = ($line_width / 2);
					break;
				}
			}
			// correct internal cell padding if required to avoid overlap between text and lines
			if ((strpos($border,'T') !== false) AND ($this->cell_padding['T'] < $adj)) {
				$this->cell_padding['T'] = $adj;
			}
			if ((strpos($border,'R') !== false) AND ($this->cell_padding['R'] < $adj)) {
				$this->cell_padding['R'] = $adj;
			}
			if ((strpos($border,'B') !== false) AND ($this->cell_padding['B'] < $adj)) {
				$this->cell_padding['B'] = $adj;
			}
			if ((strpos($border,'L') !== false) AND ($this->cell_padding['L'] < $adj)) {
				$this->cell_padding['L'] = $adj;
			}
		}
		return array('T' => ($this->cell_padding['T'] - $cp['T']), 'R' => ($this->cell_padding['R'] - $cp['R']), 'B' => ($this->cell_padding['B'] - $cp['B']), 'L' => ($this->cell_padding['L'] - $cp['L']));
	}

	/**
	 * Enables or disables the automatic page breaking mode. When enabling, the second parameter is the distance from the bottom of the page that defines the triggering limit. By default, the mode is on and the margin is 2 cm.
	 * @param $auto (boolean) Boolean indicating if mode should be on or off.
	 * @param $margin (float) Distance from the bottom of the page.
	 * @public
	 * @since 1.0
	 * @see Cell(), MultiCell(), AcceptPageBreak()
	 */
	public function SetAutoPageBreak($auto, $margin=0) {
		$this->AutoPageBreak = $auto ? true : false;
		$this->bMargin = $margin;
		$this->PageBreakTrigger = $this->h - $margin;
	}

	/**
	 * Return the auto-page-break mode (true or false).
	 * @return boolean auto-page-break mode
	 * @public
	 * @since 5.9.088
	 */
	public function getAutoPageBreak() {
		return $this->AutoPageBreak;
	}

	/**
	 * Defines the way the document is to be displayed by the viewer.
	 * @param $zoom (mixed) The zoom to use. It can be one of the following string values or a number indicating the zooming factor to use. <ul><li>fullpage: displays the entire page on screen </li><li>fullwidth: uses maximum width of window</li><li>real: uses real size (equivalent to 100% zoom)</li><li>default: uses viewer default mode</li></ul>
	 * @param $layout (string) The page layout. Possible values are:<ul><li>SinglePage Display one page at a time</li><li>OneColumn Display the pages in one column</li><li>TwoColumnLeft Display the pages in two columns, with odd-numbered pages on the left</li><li>TwoColumnRight Display the pages in two columns, with odd-numbered pages on the right</li><li>TwoPageLeft (PDF 1.5) Display the pages two at a time, with odd-numbered pages on the left</li><li>TwoPageRight (PDF 1.5) Display the pages two at a time, with odd-numbered pages on the right</li></ul>
	 * @param $mode (string) A name object specifying how the document should be displayed when opened:<ul><li>UseNone Neither document outline nor thumbnail images visible</li><li>UseOutlines Document outline visible</li><li>UseThumbs Thumbnail images visible</li><li>FullScreen Full-screen mode, with no menu bar, window controls, or any other window visible</li><li>UseOC (PDF 1.5) Optional content group panel visible</li><li>UseAttachments (PDF 1.6) Attachments panel visible</li></ul>
	 * @public
	 * @since 1.2
	 */
	public function SetDisplayMode($zoom, $layout='SinglePage', $mode='UseNone') {
		if (($zoom == 'fullpage') OR ($zoom == 'fullwidth') OR ($zoom == 'real') OR ($zoom == 'default') OR (!is_string($zoom))) {
			$this->ZoomMode = $zoom;
		} else {
			$this->Error('Incorrect zoom display mode: '.$zoom);
		}
		switch ($layout) {
			case 'default':
			case 'single':
			case 'SinglePage': {
				$this->LayoutMode = 'SinglePage';
				break;
			}
			case 'continuous':
			case 'OneColumn': {
				$this->LayoutMode = 'OneColumn';
				break;
			}
			case 'two':
			case 'TwoColumnLeft': {
				$this->LayoutMode = 'TwoColumnLeft';
				break;
			}
			case 'TwoColumnRight': {
				$this->LayoutMode = 'TwoColumnRight';
				break;
			}
			case 'TwoPageLeft': {
				$this->LayoutMode = 'TwoPageLeft';
				break;
			}
			case 'TwoPageRight': {
				$this->LayoutMode = 'TwoPageRight';
				break;
			}
			default: {
				$this->LayoutMode = 'SinglePage';
			}
		}
		switch ($mode) {
			case 'UseNone': {
				$this->PageMode = 'UseNone';
				break;
			}
			case 'UseOutlines': {
				$this->PageMode = 'UseOutlines';
				break;
			}
			case 'UseThumbs': {
				$this->PageMode = 'UseThumbs';
				break;
			}
			case 'FullScreen': {
				$this->PageMode = 'FullScreen';
				break;
			}
			case 'UseOC': {
				$this->PageMode = 'UseOC';
				break;
			}
			case '': {
				$this->PageMode = 'UseAttachments';
				break;
			}
			default: {
				$this->PageMode = 'UseNone';
			}
		}
	}

	/**
	 * Activates or deactivates page compression. When activated, the internal representation of each page is compressed, which leads to a compression ratio of about 2 for the resulting document. Compression is on by default.
	 * Note: the Zlib extension is required for this feature. If not present, compression will be turned off.
	 * @param $compress (boolean) Boolean indicating if compression must be enabled.
	 * @public
	 * @since 1.4
	 */
	public function SetCompression($compress=true) {
		if (function_exists('gzcompress')) {
			$this->compress = $compress ? true : false;
		} else {
			$this->compress = false;
		}
	}

	/**
	 * Set flag to force sRGB_IEC61966-2.1 black scaled ICC color profile for the whole document.
	 * @param $mode (boolean) If true force sRGB output intent.
	 * @public
	 * @since 5.9.121 (2011-09-28)
	 */
	public function setSRGBmode($mode=false) {
		$this->force_srgb = $mode ? true : false;
	}

	/**
	 * Turn on/off Unicode mode for document information dictionary (meta tags).
	 * This has effect only when unicode mode is set to false.
	 * @param $unicode (boolean) if true set the meta information in Unicode
	 * @since 5.9.027 (2010-12-01)
	 * @public
	 */
	public function SetDocInfoUnicode($unicode=true) {
		$this->docinfounicode = $unicode ? true : false;
	}

	/**
	 * Defines the title of the document.
	 * @param $title (string) The title.
	 * @public
	 * @since 1.2
	 * @see SetAuthor(), SetCreator(), SetKeywords(), SetSubject()
	 */
	public function SetTitle($title) {
		$this->title = $title;
	}

	/**
	 * Defines the subject of the document.
	 * @param $subject (string) The subject.
	 * @public
	 * @since 1.2
	 * @see SetAuthor(), SetCreator(), SetKeywords(), SetTitle()
	 */
	public function SetSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * Defines the author of the document.
	 * @param $author (string) The name of the author.
	 * @public
	 * @since 1.2
	 * @see SetCreator(), SetKeywords(), SetSubject(), SetTitle()
	 */
	public function SetAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Associates keywords with the document, generally in the form 'keyword1 keyword2 ...'.
	 * @param $keywords (string) The list of keywords.
	 * @public
	 * @since 1.2
	 * @see SetAuthor(), SetCreator(), SetSubject(), SetTitle()
	 */
	public function SetKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * Defines the creator of the document. This is typically the name of the application that generates the PDF.
	 * @param $creator (string) The name of the creator.
	 * @public
	 * @since 1.2
	 * @see SetAuthor(), SetKeywords(), SetSubject(), SetTitle()
	 */
	public function SetCreator($creator) {
		$this->creator = $creator;
	}

	/**
	 * This method is automatically called in case of fatal error; it simply outputs the message and halts the execution. An inherited class may override it to customize the error handling but should always halt the script, or the resulting document would probably be invalid.
	 * 2004-06-11 :: Nicola Asuni : changed bold tag with strong
	 * @param $msg (string) The error message
	 * @public
	 * @since 1.0
	 */
	public function Error($msg) {
		// unset all class variables
		$this->_destroy(true);
		// exit program and print error
		die('<strong>TCPDF ERROR: </strong>'.$msg);
	}

	/**
	 * This method begins the generation of the PDF document.
	 * It is not necessary to call it explicitly because AddPage() does it automatically.
	 * Note: no page is created by this method
	 * @public
	 * @since 1.0
	 * @see AddPage(), Close()
	 */
	public function Open() {
		$this->state = 1;
	}

	/**
	 * Terminates the PDF document.
	 * It is not necessary to call this method explicitly because Output() does it automatically.
	 * If the document contains no page, AddPage() is called to prevent from getting an invalid document.
	 * @public
	 * @since 1.0
	 * @see Open(), Output()
	 */
	public function Close() {
		if ($this->state == 3) {
			return;
		}
		if ($this->page == 0) {
			$this->AddPage();
                        
                      ///  $this->Cell(0, 15, 'http://www.softmastergroup.com',0, false, 'R', 0, 'http://www.softmastergroup.com', 0, false, 'M', 'M');
   
		}
		$this->endLayer();
		if ($this->tcpdflink) {
			// save current graphic settings
			$gvars = $this->getGraphicVars();
			$this->setEqualColumns();
			$this->lastpage(true);
			$this->SetAutoPageBreak(false);
			$this->x = 0;
			$this->y = $this->h - (1 / $this->k);
			$this->lMargin = 0;
			$this->_out('q');
			$font = defined('PDF_FONT_NAME_MAIN')?PDF_FONT_NAME_MAIN:'helvetica';
			$this->SetFont($font, '', 1);
			$this->setTextRenderingMode(0, false, false);
			$msg = "\x50\x6f\x77\x65\x72\x65\x64\x20\x62\x79\x20\x54\x43\x50\x44\x46\x20\x28\x77\x77\x77\x2e\x74\x63\x70\x64\x66\x2e\x6f\x72\x67\x29";
			$lnk = "\x68\x74\x74\x70\x3a\x2f\x2f\x77\x77\x77\x2e\x74\x63\x70\x64\x66\x2e\x6f\x72\x67";
			$this->Cell(0, 0, $msg, 0, 0, 'L', 0, $lnk, 0, false, 'D', 'B');
			$this->_out('Q');
			// restore graphic settings
			$this->setGraphicVars($gvars);
		}
		// close page
		$this->endPage();
		// close document
		$this->_enddoc();
		// unset all class variables (except critical ones)
		$this->_destroy(false);
	}

	/**
	 * Move pointer at the specified document page and update page dimensions.
	 * @param $pnum (int) page number (1 ... numpages)
	 * @param $resetmargins (boolean) if true reset left, right, top margins and Y position.
	 * @public
	 * @since 2.1.000 (2008-01-07)
	 * @see getPage(), lastpage(), getNumPages()
	 */
	public function setPage($pnum, $resetmargins=false) {
		if (($pnum == $this->page) AND ($this->state == 2)) {
			return;
		}
		if (($pnum > 0) AND ($pnum <= $this->numpages)) {
			$this->state = 2;
			// save current graphic settings
			//$gvars = $this->getGraphicVars();
			$oldpage = $this->page;
			$this->page = $pnum;
			$this->wPt = $this->pagedim[$this->page]['w'];
			$this->hPt = $this->pagedim[$this->page]['h'];
			$this->w = $this->pagedim[$this->page]['wk'];
			$this->h = $this->pagedim[$this->page]['hk'];
			$this->tMargin = $this->pagedim[$this->page]['tm'];
			$this->bMargin = $this->pagedim[$this->page]['bm'];
			$this->original_lMargin = $this->pagedim[$this->page]['olm'];
			$this->original_rMargin = $this->pagedim[$this->page]['orm'];
			$this->AutoPageBreak = $this->pagedim[$this->page]['pb'];
			$this->CurOrientation = $this->pagedim[$this->page]['or'];
			$this->SetAutoPageBreak($this->AutoPageBreak, $this->bMargin);
			// restore graphic settings
			//$this->setGraphicVars($gvars);
			if ($resetmargins) {
				$this->lMargin = $this->pagedim[$this->page]['olm'];
				$this->rMargin = $this->pagedim[$this->page]['orm'];
				$this->SetY($this->tMargin);
			} else {
				// account for booklet mode
				if ($this->pagedim[$this->page]['olm'] != $this->pagedim[$oldpage]['olm']) {
					$deltam = $this->pagedim[$this->page]['olm'] - $this->pagedim[$this->page]['orm'];
					$this->lMargin += $deltam;
					$this->rMargin -= $deltam;
				}
			}
		} else {
			$this->Error('Wrong page number on setPage() function: '.$pnum);
		}
	}

	/**
	 * Reset pointer to the last document page.
	 * @param $resetmargins (boolean) if true reset left, right, top margins and Y position.
	 * @public
	 * @since 2.0.000 (2008-01-04)
	 * @see setPage(), getPage(), getNumPages()
	 */
	public function lastPage($resetmargins=false) {
		$this->setPage($this->getNumPages(), $resetmargins);
	}

	/**
	 * Get current document page number.
	 * @return int page number
	 * @public
	 * @since 2.1.000 (2008-01-07)
	 * @see setPage(), lastpage(), getNumPages()
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * Get the total number of insered pages.
	 * @return int number of pages
	 * @public
	 * @since 2.1.000 (2008-01-07)
	 * @see setPage(), getPage(), lastpage()
	 */
	public function getNumPages() {
		return $this->numpages;
	}

	/**
	 * Adds a new TOC (Table Of Content) page to the document.
	 * @param $orientation (string) page orientation.
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
	 * @param $keepmargins (boolean) if true overwrites the default page margins with the current margins
	 * @public
	 * @since 5.0.001 (2010-05-06)
	 * @see AddPage(), startPage(), endPage(), endTOCPage()
	 */
	public function addTOCPage($orientation='', $format='', $keepmargins=false) {
		$this->AddPage($orientation, $format, $keepmargins, true);
	}

	/**
	 * Terminate the current TOC (Table Of Content) page
	 * @public
	 * @since 5.0.001 (2010-05-06)
	 * @see AddPage(), startPage(), endPage(), addTOCPage()
	 */
	public function endTOCPage() {
		$this->endPage(true);
	}

	/**
	 * Adds a new page to the document. If a page is already present, the Footer() method is called first to output the footer (if enabled). Then the page is added, the current position set to the top-left corner according to the left and top margins (or top-right if in RTL mode), and Header() is called to display the header (if enabled).
	 * The origin of the coordinate system is at the top-left corner (or top-right for RTL) and increasing ordinates go downwards.
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or PORTRAIT (default)</li><li>L or LANDSCAPE</li></ul>
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
	 * @param $keepmargins (boolean) if true overwrites the default page margins with the current margins
	 * @param $tocpage (boolean) if true set the tocpage state to true (the added page will be used to display Table Of Content).
	 * @public
	 * @since 1.0
	 * @see startPage(), endPage(), addTOCPage(), endTOCPage(), getPageSizeFromFormat(), setPageFormat()
	 */
	public function AddPage($orientation='', $format='', $keepmargins=false, $tocpage=false) {
		if ($this->inxobj) {
			// we are inside an XObject template
			return;
		}
		if (!isset($this->original_lMargin) OR $keepmargins) {
			$this->original_lMargin = $this->lMargin;
		}
		if (!isset($this->original_rMargin) OR $keepmargins) {
			$this->original_rMargin = $this->rMargin;
		}
		// terminate previous page
		$this->endPage();
		// start new page
		$this->startPage($orientation, $format, $tocpage);
	}

	/**
	 * Terminate the current page
	 * @param $tocpage (boolean) if true set the tocpage state to false (end the page used to display Table Of Content).
	 * @public
	 * @since 4.2.010 (2008-11-14)
	 * @see AddPage(), startPage(), addTOCPage(), endTOCPage()
	 */
	public function endPage($tocpage=false) {
		// check if page is already closed
		if (($this->page == 0) OR ($this->numpages > $this->page) OR (!$this->pageopen[$this->page])) {
			return;
		}
		// print page footer
		$this->setFooter();
		// close page
		$this->_endpage();
                
                
		// mark page as closed
		$this->pageopen[$this->page] = false;
		if ($tocpage) {
			$this->tocpage = false;
		}
	}

	/**
	 * Starts a new page to the document. The page must be closed using the endPage() function.
	 * The origin of the coordinate system is at the top-left corner and increasing ordinates go downwards.
	 * @param $orientation (string) page orientation. Possible values are (case insensitive):<ul><li>P or PORTRAIT (default)</li><li>L or LANDSCAPE</li></ul>
	 * @param $format (mixed) The format used for pages. It can be either: one of the string values specified at getPageSizeFromFormat() or an array of parameters specified at setPageFormat().
	 * @param $tocpage (boolean) if true the page is designated to contain the Table-Of-Content.
	 * @since 4.2.010 (2008-11-14)
	 * @see AddPage(), endPage(), addTOCPage(), endTOCPage(), getPageSizeFromFormat(), setPageFormat()
	 * @public
	 */
	public function startPage($orientation='', $format='', $tocpage=false) {
            
          
           
		if ($tocpage) {
			$this->tocpage = true;
                       
		}
		// move page numbers of documents to be attached
		if ($this->tocpage) {
			// move reference to unexistent pages (used for page attachments)
			// adjust outlines
                    
                   
                    
			$tmpoutlines = $this->outlines;
			foreach ($tmpoutlines as $key => $outline) {
				if ($outline['p'] > $this->numpages) {
					$this->outlines[$key]['p'] = ($outline['p'] + 1);
				}
			}
			// adjust dests
			$tmpdests = $this->dests;
			foreach ($tmpdests as $key => $dest) {
				if ($dest['p'] > $this->numpages) {
					$this->dests[$key]['p'] = ($dest['p'] + 1);
				}
			}
			// adjust links
			$tmplinks = $this->links;
			foreach ($tmplinks as $key => $link) {
				if ($link[0] > $this->numpages) {
					$this->links[$key][0] = ($link[0] + 1);
				}
			}
		}
		if ($this->numpages > $this->page) {
			// this page has been already added
			$this->setPage($this->page + 1);
			$this->SetY($this->tMargin);
			return;
		}
		// start a new page
		if ($this->state == 0) {
			$this->Open();
		}
		++$this->numpages;
		$this->swapMargins($this->booklet);
		// save current graphic settings
		$gvars = $this->getGraphicVars();
		// start new page
                
                
                
		$this->_beginpage($orientation, $format);
		// mark page as open
		$this->pageopen[$this->page] = true;
		// restore graphic settings
		$this->setGraphicVars($gvars);
		// mark this point
		$this->setPageMark();
		// print page header
		$this->setHeader();
		// restore graphic settings
		$this->setGraphicVars($gvars);
		// mark this point
		$this->setPageMark();
		// print table header (if any)
		$this->setTableHeader();
		// set mark for empty page check
		$this->emptypagemrk[$this->page]= $this->pagelen[$this->page];
	}

	/**
	 * Set start-writing mark on current page stream used to put borders and fills.
	 * Borders and fills are always created after content and inserted on the position marked by this method.
	 * This function must be called after calling Image() function for a background image.
	 * Background images must be always inserted before calling Multicell() or WriteHTMLCell() or WriteHTML() functions.
	 * @public
	 * @since 4.0.016 (2008-07-30)
	 */
	public function setPageMark() {
		$this->intmrk[$this->page] = $this->pagelen[$this->page];
		$this->bordermrk[$this->page] = $this->intmrk[$this->page];
		$this->setContentMark();
	}

	/**
	 * Set start-writing mark on selected page.
	 * Borders and fills are always created after content and inserted on the position marked by this method.
	 * @param $page (int) page number (default is the current page)
	 * @protected
	 * @since 4.6.021 (2009-07-20)
	 */
	protected function setContentMark($page=0) {
		if ($page <= 0) {
			$page = $this->page;
		}
		if (isset($this->footerlen[$page])) {
			$this->cntmrk[$page] = $this->pagelen[$page] - $this->footerlen[$page];
		} else {
			$this->cntmrk[$page] = $this->pagelen[$page];
		}
	}

	/**
	 * Set header data.
	 * @param $ln (string) header image logo
	 * @param $lw (string) header image logo width in mm
	 * @param $ht (string) string to print as title on document header
	 * @param $hs (string) string to print on document header
	 * @public
	 */
	public function setHeaderData($ln='', $lw=0, $ht='', $hs='') {
		$this->header_logo = $ln;
		$this->header_logo_width = $lw;
		$this->header_title = $ht;
		$this->header_string = $hs;
	}

	/**
	 * Returns header data:
	 * <ul><li>$ret['logo'] = logo image</li><li>$ret['logo_width'] = width of the image logo in user units</li><li>$ret['title'] = header title</li><li>$ret['string'] = header description string</li></ul>
	 * @return array()
	 * @public
	 * @since 4.0.012 (2008-07-24)
	 */
	public function getHeaderData() {
		$ret = array();
		$ret['logo'] = $this->header_logo;
		$ret['logo_width'] = $this->header_logo_width;
		$ret['title'] = $this->header_title;
		$ret['string'] = $this->header_string;
		return $ret;
	}

	/**
	 * Set header margin.
	 * (minimum distance between header and top page margin)
	 * @param $hm (int) distance in user units
	 * @public
	 */
	public function setHeaderMargin($hm=10) {
		$this->header_margin = $hm;
	}

	/**
	 * Returns header margin in user units.
	 * @return float
	 * @since 4.0.012 (2008-07-24)
	 * @public
	 */
	public function getHeaderMargin() {
		return $this->header_margin;
	}

	/**
	 * Set footer margin.
	 * (minimum distance between footer and bottom page margin)
	 * @param $fm (int) distance in user units
	 * @public
	 */
	public function setFooterMargin($fm=10) {
		$this->footer_margin = $fm;
	}

	/**
	 * Returns footer margin in user units.
	 * @return float
	 * @since 4.0.012 (2008-07-24)
	 * @public
	 */
	public function getFooterMargin() {
		return $this->footer_margin;
	}
	/**
	 * Set a flag to print page header.
	 * @param $val (boolean) set to true to print the page header (default), false otherwise.
	 * @public
	 */
	public function setPrintHeader($val=true,$type) {
		$this->print_header = $val ? true : false;    
		$this->print_type = $type;  
		$this->my_print_type= $type;  

		
	}

	/**
	 * Set a flag to print page footer.
	 * @param $val (boolean) set to true to print the page footer (default), false otherwise.
	 * @public
	 */
	public function setPrintFooter($val=true,$type,$is_cur_time) {
        $this->print_footer = $val ? true : false;
        $this->print_type1 = $type; 
       // var_dump($is_cur_time);
        $this->is_time($is_cur_time);
	}

	/**
	 * Return the right-bottom (or left-bottom for RTL) corner X coordinate of last inserted image
	 * @return float
	 * @public
	 */
	public function getImageRBX() {
		return $this->img_rb_x;
	}

	/**
	 * Return the right-bottom (or left-bottom for RTL) corner Y coordinate of last inserted image
	 * @return float
	 * @public
	 */
	public function getImageRBY() {
		return $this->img_rb_y;
	}

	/**
	 * Reset the xobject template used by Header() method.
	 * @public
	 */
	public function resetHeaderTemplate() {
		$this->header_xobjid = -1;
	}

	/**
	 * Set a flag to automatically reset the xobject template used by Header() method at each page.
	 * @param $val (boolean) set to true to reset Header xobject template at each page, false otherwise.
	 * @public
	 */
	public function setHeaderTemplateAutoreset($val=true) {
		$this->header_xobj_autoreset = $val ? true : false;
	}

	/**
	 * This method is used to render the page header.
	 * It is automatically called by AddPage() and could be overwritten in your own inherited class.
	 * @public
	 */


	public function Header($type) {

						$count=$this->PageNo(); 

						if($type=="f_find_serial"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->SetX(25);
		                        $this->SetFont('helvetica','IB',9);
		                        $this->Cell(30, 6," Trans Code", '1', 0, 'C', 0);
								$this->Cell(20, 6," Trans No ", '1', 0, 'C', 0);
								$this->Cell(20, 6," Trans Date", '1', 0, 'C', 0);
		                        $this->Cell(30, 6," Item", '1', 0, 'C', 0);
		                        $this->Cell(60, 6," Item Description", '1', 0, 'C', 0);
		                        $this->Cell(30, 6," Serial No", '1', 0, 'C', 0);
		                        $this->Cell(30, 6," Other No", '1', 0, 'C', 0);
		                        $this->Cell(30, 6," Other No", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    	$this->SetY(34);
		                    	$this->SetX(25);
		                        $this->SetFont('helvetica','IB',9);
		                        $this->Cell(30, 6," Trans Code", '1', 0, 'C', 0);
								$this->Cell(20, 6," Trans No ", '1', 0, 'C', 0);
								$this->Cell(20, 6," Trans Date", '1', 0, 'C', 0);
		                        $this->Cell(30, 6," Item", '1', 0, 'C', 0);
		                        $this->Cell(60, 6," Item Description", '1', 0, 'C', 0);
		                        $this->Cell(30, 6," Serial No", '1', 0, 'C', 0);
		                        $this->Cell(30, 6," Other No", '1', 0, 'C', 0);
		                        $this->Cell(30, 6," Other No", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}

					if($type=="r_stock_in_hand"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
								$this->Cell(40, 6,"Item Name",'1', 0, 'C', 0);
								$this->Cell(20, 6,"Item Model ", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"Qty ", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Purchase Price  ", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Last Price ", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Max Price", '1', 0, 'C', 0);
		                    	$this->Cell(25, 6,"Total", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    	
		                    	$this->SetY(55);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(25, 6," Item Code", '1', 0, 'C', 0);
								$this->Cell(40, 6," Item Name", '1', 0, 'C', 0);
								$this->Cell(20, 6," Item Model", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"Qty", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Purchase Price  ", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Last Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Max Price", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Total", '1', 0, 'C', 0);	
		                        $this->Ln();
		                    	}
						}


						if($type=="r_batch_in_hand"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(25, 6," Item Code", '1', 0, 'C', 0);
								$this->Cell(55, 6," Item Name", '1', 0, 'C', 0);
								$this->Cell(25, 6," Item Model  ", '1', 0, 'C', 0);
								$this->Cell(22, 6,"Purchase Price   ", '1', 0, 'C', 0);
								$this->Cell(22, 6,"Purchase Date   ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Batch No   ", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"Qty", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"Total Qty   ", '1', 0, 'C', 0);
		                    
		                        $this->Ln();
		                    	}else{
		                    	
		                    	$this->SetY(50);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	$this->Cell(25, 6," Item Code", '1', 0, 'C', 0);
								$this->Cell(55, 6," Item Name", '1', 0, 'C', 0);
								$this->Cell(25, 6," Item Model  ", '1', 0, 'C', 0);
								$this->Cell(22, 6,"Purchase Price   ", '1', 0, 'C', 0);
								$this->Cell(22, 6,"Purchase Date   ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Batch No   ", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"Qty", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"Total Qty   ", '1', 0, 'C', 0);
		                        	
		                        $this->Ln();
		                    	}
						}

						if($type=="r_bin_card_stock"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(25, 6," Date", '1', 0, 'C', 0);
								$this->Cell(55, 6," Description", '1', 0, 'C', 0);
								$this->Cell(25, 6," No.  ", '1', 0, 'C', 0);
								$this->Cell(22, 6,"Item In   ", '1', 0, 'C', 0);
								$this->Cell(22, 6,"Item Out   ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Balance   ", '1', 0, 'C', 0);
		                       
		                        $this->Ln();
		                    	}else{
		                    	
		                    	$this->SetY(50);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	 $this->Cell(25, 6," Date", '1', 0, 'C', 0);
								$this->Cell(55, 6," Description", '1', 0, 'C', 0);
								$this->Cell(25, 6," No.  ", '1', 0, 'C', 0);
								$this->Cell(22, 6,"Item In   ", '1', 0, 'C', 0);
								$this->Cell(22, 6,"Item Out   ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Balance   ", '1', 0, 'C', 0);
		                       
		                        $this->Ln();
		                    	}
						}


						if($type=="r_stock_detail"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(25, 6," ID", '1', 0, 'C', 0);
        						$this->Cell(90, 6," Item", '1', 0, 'C', 0);
        						$this->Cell(35, 6," Model No", '1', 0, 'C', 0);
        						$this->Cell(22, 6,"Pur.Price  ", '1', 0, 'C', 0);
        						$this->Cell(22, 6,"Max.Price  ", '1', 0, 'C', 0);
        						$this->Cell(20, 6,"Last Price  ", '1', 0, 'C', 0);
        						$this->Cell(20, 6,"ROL  ", '1', 0, 'C', 0);
        						$this->Cell(20, 6,"ROQ  ", '1', 0, 'C', 0);
        						$this->Cell(20, 6," Sup.ID", '1', 0, 'C', 0);
		                       
		                        $this->Ln();
		                    	}else{
		                    	
		                    	$this->SetY(50);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	$this->Cell(25, 6," ID", '1', 0, 'C', 0);
        						$this->Cell(90, 6," Item", '1', 0, 'C', 0);
        						$this->Cell(35, 6," Model No", '1', 0, 'C', 0);
        						$this->Cell(22, 6,"Pur.Price  ", '1', 0, 'C', 0);
        						$this->Cell(22, 6,"Max.Price  ", '1', 0, 'C', 0);
        						$this->Cell(20, 6,"Last Price  ", '1', 0, 'C', 0);
        						$this->Cell(20, 6,"ROL  ", '1', 0, 'C', 0);
        						$this->Cell(20, 6,"ROQ  ", '1', 0, 'C', 0);
        						$this->Cell(20, 6," Sup.ID", '1', 0, 'C', 0);
		                       
		                        $this->Ln();
		                    	}
						}


						if($type=="r_item_category"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(50, 6," Code", '1', 0, 'C', 0);
        						$this->Cell(110, 6," Name", '1', 0, 'C', 0);
								$this->Ln();
		                    	}else{
		                    	
		                    	$this->SetY(50);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	$this->Cell(50, 6," Code", '1', 0, 'C', 0);
        						$this->Cell(110, 6," Name", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}

						if($type=="r_supplier2"){
							if($count>1){	
					 			$this->SetY(5);
				                $this->SetX(10);
				                $this->SetFont('helvetica','B',8);
				                $this->Cell(20, 6,"Code", '1', 0, 'C', 0);
				                $this->Cell(64, 6,"Company Name", '1', 0, 'C', 0);
				                $this->Cell(30, 6,"Cont.Ref", '1', 0, 'C', 0);
				                $this->Cell(22, 6,"Off.No", '1', 0, 'C', 0);
				                $this->Cell(21, 6,"Fax", '1', 0, 'C', 0);
				                $this->Cell(21, 6,"Mobile", '1', 0, 'C', 0);
				                $this->Cell(21, 6,"Res.No", '1', 0, 'C', 0);
				                $this->Ln();
		                    }else{
		                    	$this->SetY(35);
				                $this->SetX(10);
				                $this->SetFont('helvetica','B',8);
				                $this->Cell(20, 6,"Code", '1', 0, 'C', 0);
				                $this->Cell(64, 6,"Company Name", '1', 0, 'C', 0);
				                $this->Cell(30, 6,"Cont.Ref", '1', 0, 'C', 0);
				                $this->Cell(22, 6,"Off.No", '1', 0, 'C', 0);
				                $this->Cell(21, 6,"Fax", '1', 0, 'C', 0);
				                $this->Cell(21, 6,"Mobile", '1', 0, 'C', 0);
				                $this->Cell(21, 6,"Res.No", '1', 0, 'C', 0);
				                $this->Ln();
		                    	}
						}


						if($type=="r_sub_item_category"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(15, 6," Code", '1', 0, 'C', 0);
        						$this->Cell(60, 6," Description", '1', 0, 'C', 0);
        						$this->Cell(25, 6," Sub Category", '1', 0, 'C', 0);
							    $this->Cell(60, 6," Sub Category Name", '1', 0, 'C', 0);
								$this->Ln();
		                    	
		                    	}else{
		                    	
		                    	$this->SetY(55);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	$this->Cell(15, 6," Code", '1', 0, 'C', 0);
        						$this->Cell(60, 6," Description", '1', 0, 'C', 0);
        						$this->Cell(25, 6," Sub Category", '1', 0, 'C', 0);
							    $this->Cell(60, 6," Sub Category Name", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}


						if($type=="item_lists"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(30, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(60, 6,"Description", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Dep Id", '1', 0, 'C', 0);
								$this->Cell(30, 6,"Department Name", '1', 0, 'C', 0);
								$this->Cell(30, 6,"Category ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Brand", '1', 0, 'C', 0);
								$this->Cell(30, 6,"Model", '1', 0, 'C', 0);
								$this->Cell(18, 6,"Max Price", '1', 0, 'C', 0);
								$this->Cell(18, 6,"Min Price", '1', 0, 'C', 0);						
								
								$this->Ln();
		                    	
		                    	}else{
		                    	
		                    	$this->SetY(50);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	$this->Cell(30, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(60, 6,"Description", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Dep", '1', 0, 'C', 0);
								$this->Cell(30, 6,"Department Name", '1', 0, 'C', 0);
								$this->Cell(30, 6,"Category ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Brand", '1', 0, 'C', 0);
								$this->Cell(30, 6,"Model", '1', 0, 'C', 0);
								$this->Cell(18, 6,"Max Price", '1', 0, 'C', 0);
								$this->Cell(18, 6,"Min Price", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}

						if($type=="r_item_list_prices"){
							if($count>1){	

								$this->SetY(35);
					 			$this->setX(10);
					 			$this->Cell(30, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(55, 6,"Description", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Supplier", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Present", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Purchase", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Regular ", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Discounted", '1', 0, 'C', 0);							
								$this->Ln();
		                    	
		                    	}else{
		                    	
		                    	$this->SetY(50);
		                    	$this->SetX(10);
		                    	$this->Cell(30, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(55, 6,"Description", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Supplier", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Present", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Purchase", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Regular ", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Discounted", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}


						if($type=="r_sales_det"){
							if($count>1){	

								$this->SetY(35);
					 			$this->setX(15);
					 			$this->Cell(30, 6,"Code", '1', 0, 'C', 0);
							    $this->Cell(80, 6,"Description", '1', 0, 'C', 0);
							    $this->Cell(30, 6,"Purchase price", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Max Price", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Min Price", '1', 0, 'C', 0);				
								
								$this->Ln();
		                    	
		                    	}else{
		                    	
		                    	$this->SetY(57);
		                    	$this->SetX(15);
		                    	$this->Cell(30, 6,"Code", '1', 0, 'C', 0);
							    $this->Cell(80, 6,"Description", '1', 0, 'C', 0);
							    $this->Cell(30, 6,"Purchase price", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Max Price", '1', 0, 'C', 0);
							    $this->Cell(20, 6,"Min Price", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}


						if($type=="r_item_sales"){
							if($count>1){	

								$this->SetY(35);
					 			$this->setX(15);
					 			$this->Cell(30, 6,"Code", '1', 0, 'C', 0);
							    $this->Cell(150,6,"Description", '1', 0, 'C', 0);
							    							
								$this->Ln();
		                    	
		                    	}else{
		                    	
		                    	$this->SetY(57);
		                    	$this->SetX(15);
		                    	$this->Cell(30, 6,"Code", '1', 0, 'C', 0);
							    $this->Cell(150,6,"Description", '1', 0, 'C', 0);
							    
		                        $this->Ln();
		                    	}
						}


							if($type=="r_stock_details"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(25, 6," Code", '1', 0, 'C', 0);
								$this->Cell(50, 6," Description", '1', 0, 'C', 0);
								$this->Cell(35, 6," Model", '1', 0, 'C', 0);								
								$this->Cell(20, 6,"OP Balance  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Purchase  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Cash S  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Credit S  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Sales Return  ", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Clossing Balance  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"EOQ  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"ROQ  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Buffer  ", '1', 0, 'C', 0);
								$this->Ln();
		                    	
		                    	}else{
		                    	
		                    	$this->SetY(60);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	$this->Cell(25, 6," Code", '1', 0, 'L', 0);
								$this->Cell(50, 6," Description", '1', 0, 'C', 0);
								$this->Cell(35, 6," Model", '1', 0, 'L', 0);								
								$this->Cell(20, 6,"OP Balance  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Purchase  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Cash S  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Credit S  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Sales Return  ", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Clossing Balance  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"EOQ  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"ROQ  ", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Buffer  ", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}

						if($type=="r_po_qty_received"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                        $this->Cell(60, 6,"  Supplier", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Po No  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"  Date", '1', 0, 'C', 0);
								$this->Cell(35, 6,"  Item  ", '1', 0, 'C', 0);
								$this->Cell(75, 6,"  Description  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Order Qty  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Received Qty  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Balance Qty  ", '1', 0, 'C', 0);
								$this->Ln();
		                    	
		                    	}else{
		                    	
		                    	$this->SetY(40);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	$this->Cell(60, 6,"  Supplier", '1', 0, 'C', 0);
								$this->Cell(15, 6,"Po No  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"  Date", '1', 0, 'C', 0);
								$this->Cell(35, 6,"  Item  ", '1', 0, 'C', 0);
								$this->Cell(75, 6,"  Description  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Order Qty  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Received Qty  ", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Balance Qty  ", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}
						if($type=="r_po_status"){
							if($count>1){	

					 			$this->SetY(34);
					 			$this->setX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	$this->Cell(10, 6,"No", '1', 0, 'C', 0);
		                        $this->Cell(50, 6,"Purchase Request", '1', 0, 'C', 0);
								$this->Cell(50, 6,"PR Approve", '1', 0, 'C', 0);
								$this->Cell(50, 6,"Purchase Order", '1', 0, 'C', 0);
								$this->Cell(50, 6,"Purchase", '1', 0, 'C', 0);
								$this->Cell(50, 6,"Internal Transfer Order No", '1', 0, 'C', 0);
								$this->Ln();
		                    	
		                    	}else{
		                    	
		                    	$this->SetY(60);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',8);
		                    	//$this->Cell(10, 6,"No", '1', 0, 'C', 0);
		                    	$this->Cell(100, 6,"Purchase Request", '1', 0, 'C', 0);
								$this->Cell(50, 6,"PR Approve", '1', 0, 'C', 0);
								$this->Cell(40, 6,"Purchase Order", '1', 0, 'C', 0);
								$this->Cell(40, 6,"Purchase", '1', 0, 'C', 0);
								$this->Cell(40, 6,"Internal Transfer Order No", '1', 0, 'C', 0);
		                        $this->Ln();
		                        $this->SetX(15);
		                        $this->Cell(10, 6,"No", '1', 0, 'C', 0);
		                        $this->Cell(50, 6,"Item", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Save", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Approve", '1', 0, 'C', 0);
								$this->Cell(10, 6,"No", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Save", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Approve", '1', 0, 'C', 0);
								$this->Cell(20, 6,"No", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Qty", '1', 0, 'C', 0);
								$this->Cell(20, 6,"No", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Qty", '1', 0, 'C', 0);
								$this->Cell(20, 6,"No", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Qty", '1', 0, 'C', 0);
								$this->Ln();
								$this->SetX(15);
		                        $this->Cell(10, 6,"", '1', 0, 'C', 0);
		                        $this->Cell(50, 6,"", '1', 0, 'C', 0);
								$this->Cell(10, 6,"Ok", '1', 0, 'C', 0);
								$this->Cell(10, 6,"Qty", '1', 0, 'C', 0);
								$this->Cell(10, 6,"Ok", '1', 0, 'C', 0);
								$this->Cell(10, 6,"Qty", '1', 0, 'C', 0);
								$this->Cell(10, 6,"", '1', 0, 'C', 0);
								$this->Cell(10, 6,"Ok", '1', 0, 'C', 0);
								$this->Cell(10, 6,"Qty", '1', 0, 'C', 0);
								$this->Cell(10, 6,"Ok", '1', 0, 'C', 0);
								$this->Cell(10, 6,"Qty", '1', 0, 'C', 0);
								$this->Cell(20, 6,"", '1', 0, 'C', 0);
								$this->Cell(20, 6,"", '1', 0, 'C', 0);
								$this->Cell(20, 6,"", '1', 0, 'C', 0);
								$this->Cell(20, 6,"", '1', 0, 'C', 0);
								$this->Cell(20, 6,"", '1', 0, 'C', 0);
								$this->Cell(20, 6,"", '1', 0, 'C', 0);
		                    	}
						}

						if($type=="r_serial_in_hand"){
							if($count>1){	

								
					 		// 	$this->SetY(34);
					 		// 	$this->SetX(25);
		      //               	$this->SetFont('helvetica','B',9);
		      //                   $this->Cell(30, 6," Item Code", '1', 0, 'L', 0);
								// $this->Cell(60, 6," Item Name", '1', 0, 'L', 0);
								// $this->Cell(30, 6," Item Model", '1', 0, 'L', 0);
		      //                   $this->Cell(20, 6," Quantity  ", '1', 0, 'R', 0);
		      //                   $this->Cell(20, 6," Serial No", '1', 0, 'L', 0);
		                        
		                    
		      //                   $this->Ln();
		                    	}else{
		                    	
		                    	$this->SetY(51);
		                    	$this->SetX(15);
		                    	$this->SetFont('helvetica','B',9);
		                        $this->Cell(30, 6," Item Code", '1', 0, 'C', 0);
								$this->Cell(60, 6," Item Name", '1', 0, 'C', 0);
								$this->Cell(30, 6," Item Model", '1', 0, 'C', 0);
		                        $this->Cell(20, 6," Quantity  ", '1', 0, 'C', 0);
		                        $this->Cell(20, 6," Serial No", '1', 0, 'C', 0);
		                        
		                        	
		                        $this->Ln();
		                    	}
						}	
							


						if($type=="sales"){
							if($count>1){	

					 			$this->SetY(34);
		                        $this->SetFont('helvetica','IB',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(30, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    		$this->SetY(45);
		                        $this->SetFont('helvetica','IB',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(20, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(30, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}


						if($type=="r_account_chart"){
							if($count>1){	
						 			$this->SetY(34);
						 			$this->SetX(20);
			                        $this->SetFont('helvetica','B',8);
			            //             $this->Cell(40, 6," R Type", '1', 0, 'L', 0);
							        // $this->Cell(25, 6," Type", '1', 0, 'L', 0); 
							        // $this->Cell(17, 6," Code", '1', 0, 'L', 0);
							        // $this->Cell(55, 6," Description", '1', 0, 'L', 0);
							        // $this->Cell(15, 6," Ctrl Acc", '1', 0, 'L', 0);
							        // $this->Cell(20, 6," Is Ctrl Acc", '1', 0, 'L', 0);


		                    	}else{
		                    		$this->SetY(41);
		                   			$this->SetX(20);
			                        $this->SetFont('helvetica','B',8);
			         //                $this->Cell(30, 6,"Account Code", '1', 0, 'L', 0);
								    // $this->Cell(60, 6,"Description", '1', 0, 'L', 0);
								    // $this->Cell(30, 6,"Control Acc Code", '1', 0, 'L', 0);
								    // $this->Cell(60, 6,"Cont Acc Description", '1', 0, 'L', 0);


			            //             $this->Cell(40, 6," R Type", '1', 0, 'L', 0);
							        // $this->Cell(25, 6," Type", '1', 0, 'L', 0); 
							        // $this->Cell(17, 6," Code", '1', 0, 'L', 0);
							        // $this->Cell(55, 6," Description", '1', 0, 'L', 0);
							        // $this->Cell(15, 6," Ctrl Acc", '1', 0, 'L', 0);
							        // $this->Cell(20, 6," Is Ctrl Acc", '1', 0, 'L', 0);
			                        $this->Ln();
		                    	}
						}

						if($type=="r_account_update"){
							if($count>1){	
						 			$this->SetY(34);
						 			$this->SetX(20);
			                        $this->SetFont('helvetica','B',8);
			                        $this->Cell(40, 6," Type", '1', 0, 'C', 0);
							        $this->Cell(15, 6,"No ", '1', 0, 'C', 0); 
							        $this->Cell(20, 6," Acc Code", '1', 0, 'C', 0);
							        $this->Cell(57, 6," Description", '1', 0, 'C', 0);
							        $this->Cell(20, 6,"Debit ", '1', 0, 'C', 0);
							        $this->Cell(20, 6,"Credit ", '1', 0, 'C', 0);
			                        $this->Ln();
		                    	}else{
		                    		$this->SetY(41);
		                   			$this->SetX(20);
			                        $this->SetFont('helvetica','B',8);
			                        $this->Cell(40, 6," Type", '1', 0, 'C', 0);
							        $this->Cell(15, 6,"No ", '1', 0, 'C', 0); 
							        $this->Cell(20, 6," Acc Code", '1', 0, 'C', 0);
							        $this->Cell(57, 6," Description", '1', 0, 'C', 0);
							        $this->Cell(20, 6,"Debit ", '1', 0, 'C', 0);
							        $this->Cell(20, 6,"Credit ", '1', 0, 'C', 0);
			                        $this->Ln();
		                    	}
						}


						

						if($type=="cash_sales"){
							//var_dump($count);
							if($count>1){	
					 			$this->SetY(30);
					 			$this->SetX(10);
		                        $this->SetFont('helvetica','B',9);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(35, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(17, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    	$this->SetY(40);
		                    	$this->SetX(10);
		                        $this->SetFont('helvetica','B',9);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(35, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(17, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}
						
						
						if($type=="t_internal_transfer"){
							if($count>1){	
					 			$this->SetY(34);
					 			$this->SetX(25);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    	$this->SetY(36);
		                    	$this->SetX(25);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}

						if($type=="t_internal_transfer_receive"){
							if($count>1){	
					 			$this->SetY(35);
					 			$this->SetX(25);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    	$this->SetY(36);
		                    	$this->SetX(25);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}

						if($type=="credit_sales"){
							if($count>1){	


					 			$this->SetY(24);
					 			$this->setX(16);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(30, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(17, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    		$this->SetY(45);
		                    		$this->setX(16);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(30, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(18, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(17, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}


						if($type=="r_trial_balance"){
							if($count>1){	
							
								$this->SetY(30);
								$this->SetX(8);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(15, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(70, 6,"Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Dr. Amount", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Cr. Amount", '1', 0, 'C', 0);
		                        $this->Cell(5, 6,"", '0', 0, 'C', 0);
		                        $this->Cell(25, 6,"Dr. Amount", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Cr. Amount", '1', 0, 'C', 0);
		                        $this->Ln();
							}else{

								$this->SetY(37);
								$this->SetX(8);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(15, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(70, 6,"Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Dr. Amount", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Cr. Amount", '1', 0, 'C', 0);
		                        $this->Cell(5, 6,"", '0', 0, 'C', 0);
		                        $this->Cell(25, 6,"Dr. Amount", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Cr. Amount", '1', 0, 'C', 0);
		                        $this->Ln();


							}
						}


						if($type=="sales_return"){
							if($count>1){	


					 			$this->SetY(34);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    		$this->SetY(45);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}



						if($type=="purchase_return"){
							if($count>1){	


					 			$this->SetY(34);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    		$this->SetY(45);
		                        $this->SetFont('helvetica','B',8);
		                        $this->Cell(10, 6,"Sr. No", '1', 0, 'C', 0);
								$this->Cell(25, 6,"Item Code", '1', 0, 'C', 0);
		                        $this->Cell(55, 6,"Item Description", '1', 0, 'C', 0);
		                        $this->Cell(25, 6,"Module", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Unit Price", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Net Value", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}




						if($type=="purchase_quotation"){
							if($count>1){		
					 			$this->SetY(45);
		                        $this->SetFont('helvetica','IB',8);
 								$this->MultiCell(10, 9, "No", $border=1, $align='C', $fill=false, $ln=0, $x='10', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(25, 9, "Item Code", $border=1, $align='C', $fill=false, $ln=0, $x='20', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(60, 9, "Item Description", $border=1, $align='C', $fill=false, $ln=0, $x='45', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Module", $border=1, $align='C', $fill=false, $ln=0, $x='105', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Current", $border=1, $align='C', $fill=false, $ln=0, $x='120', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=6, $valign='M', $fitcell=false);
		                        $this->MultiCell(20, 9, "Order[QT]", $border=1, $align='C', $fill=false, $ln=0, $x='135', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(20, 9, "Cost Price", $border=1, $align='C', $fill=false, $ln=0, $x='155', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(25, 9, "Amount", $border=1, $align='C', $fill=false, $ln=0, $x='180', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 6, "QTY", $border=0, $align='C', $fill=false, $ln=0, $x='120', $y='66', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=9, $valign='T', $fitcell=true);
		                        
		                        $this->Ln();
		                    	}else{
		                    		$this->SetY(50);
		                        $this->SetFont('helvetica','IB',8);

		                        $this->MultiCell(10, 9, "No", $border=1, $align='C', $fill=false, $ln=0, $x='10', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(25, 9, "Item Code", $border=1, $align='C', $fill=false, $ln=0, $x='20', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(60, 9, "Item Description", $border=1, $align='C', $fill=false, $ln=0, $x='45', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Module", $border=1, $align='C', $fill=false, $ln=0, $x='105', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Current", $border=1, $align='C', $fill=false, $ln=0, $x='120', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=6, $valign='M', $fitcell=false);
		                        $this->MultiCell(20, 9, "Order[QT]", $border=1, $align='C', $fill=false, $ln=0, $x='135', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(20, 9, "Cost Price", $border=1, $align='C', $fill=false, $ln=0, $x='155', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(25, 9, "Amount", $border=1, $align='C', $fill=false, $ln=0, $x='175', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 6, "QTY", $border=0, $align='C', $fill=false, $ln=0, $x='120', $y='66', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=9, $valign='T', $fitcell=true);
		                        
		                        $this->Ln();


		                    	}
						}


						if($type=="t_internal_transfer_order"){
							if($count>1){		
					 			$this->SetY(45);
		                        $this->SetFont('helvetica','IB',8);
 								  $this->MultiCell(10, 9, "No", $border=1, $align='C', $fill=false, $ln=0, $x='10', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(25, 9, "Item Code", $border=1, $align='C', $fill=false, $ln=0, $x='20', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(45, 9, "Item Name", $border=1, $align='C', $fill=false, $ln=0, $x='45', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(30, 9, "Model", $border=1, $align='C', $fill=false, $ln=0, $x='90', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Cost", $border=1, $align='C', $fill=false, $ln=0, $x='120', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=9, $valign='M', $fitcell=false);
		                        $this->MultiCell(15, 9, "Min Price", $border=1, $align='C', $fill=false, $ln=0, $x='135', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Max Price", $border=1, $align='C', $fill=false, $ln=0, $x='150', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                       	$this->MultiCell(15, 9, "Qty", $border=1, $align='C', $fill=false, $ln=0, $x='165', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(20, 9, "Amount", $border=1, $align='C', $fill=false, $ln=0, $x='180', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        
		                        
		                        $this->Ln();
		                    	}else{
		                    		$this->SetY(50);
		                        $this->SetFont('helvetica','B',8);

		                        $this->MultiCell(10, 9, "No", $border=1, $align='C', $fill=false, $ln=0, $x='10', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(25, 9, "Item Code", $border=1, $align='C', $fill=false, $ln=0, $x='20', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(45, 9, "Item Name", $border=1, $align='C', $fill=false, $ln=0, $x='45', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(30, 9, "Model", $border=1, $align='C', $fill=false, $ln=0, $x='90', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Cost", $border=1, $align='C', $fill=false, $ln=0, $x='120', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=9, $valign='M', $fitcell=false);
		                        $this->MultiCell(15, 9, "Min Price", $border=1, $align='C', $fill=false, $ln=0, $x='135', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Max Price", $border=1, $align='C', $fill=false, $ln=0, $x='150', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                       	$this->MultiCell(15, 9, "Qty", $border=1, $align='C', $fill=false, $ln=0, $x='165', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(20, 9, "Amount", $border=1, $align='C', $fill=false, $ln=0, $x='180', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        
		                        $this->Ln();


		                    	}
						}




						if($type=="purchase"){

							if($count>1){		

					 			$this->SetY(34);

					 			$this->Setx(2);

		                        $this->SetFont('helvetica','B',8);



		                        $this->Cell(8, 9,"No", '1', 0, 'C', 0);

								$this->Cell(28, 9,"Item Code", '1', 0, 'C', 0);

		                        $this->Cell(30, 9,"Item Description", '1', 0, 'C', 0);

		                        $this->Cell(20, 9,"Module", '1', 0, 'C', 0);

		                        $this->Cell(8, 9,"QTY", '1', 0, 'C', 0);

		                        $this->Cell(8, 9,"FOC", '1', 0, 'C', 0);

		                        $this->Cell(17, 9,"Unit Price", '1', 0, 'C', 0);

		                        $this->Cell(17, 9,"Last Price", '1', 0, 'C', 0);

		                        $this->Cell(15, 9,"Sales Price", '1', 0, 'C', 0);

		                        //$this->Cell(10, 9,"Sales Pro.", '1', 0, 'C', 0);

		                        $this->Cell(15, 9,"Discount", '1', 0, 'C', 0);

		                        //$this->Cell(10, 9,"Profit", '1', 0, 'C', 0);

		                        $this->Cell(10, 9,"L.P.M", '1', 0, 'C', 0);

		                        $this->Cell(10, 9,"S.P.M", '1', 0, 'C', 0);

		                        $this->Cell(20, 9,"Amount", '1', 0, 'C', 0);

		     					$this->Ln();

 								/*$this->MultiCell(5, 9, "No", $border=1, $align='C', $fill=false, $ln=0, $x='5', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(25, 9, "Item Code", $border=1, $align='C', $fill=false, $ln=0, $x='15', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(30, 9, "Item Description", $border=1, $align='C', $fill=false, $ln=0, $x='35', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(20, 9, "Module", $border=1, $align='C', $fill=false, $ln=0, $x='75', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(10, 9, "QTY", $border=1, $align='C', $fill=false, $ln=0, $x='85', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=6, $valign='M', $fitcell=false);
		                        $this->MultiCell(10, 9, "FOC", $border=1, $align='C', $fill=false, $ln=0, $x='90', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=6, $valign='M', $fitcell=false);
		                        $this->MultiCell(15, 9, "Unit Price", $border=1, $align='C', $fill=false, $ln=0, $x='100', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Last Price", $border=1, $align='C', $fill=false, $ln=0, $x='115', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Sales Price", $border=1, $align='C', $fill=false, $ln=0, $x='130', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Sales Pro.", $border=1, $align='C', $fill=false, $ln=0, $x='145', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Discount", $border=1, $align='C', $fill=false, $ln=0, $x='160', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(10, 9, "Profit", $border=1, $align='C', $fill=false, $ln=0, $x='175', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(20, 9, "Amount", $border=1, $align='C', $fill=false, $ln=0, $x='185', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                 		*/
		                        
		                    }else{

	                    		$this->SetY(60);

	                    		$this->Setx(2);

		                        $this->SetFont('helvetica','B',8);

		                        $this->Cell(8, 9,"No", '1', 0, 'C', 0);

								$this->Cell(28, 9,"Item Code", '1', 0, 'C', 0);

		                        $this->Cell(30, 9,"Item Description", '1', 0, 'C', 0);

		                        $this->Cell(20, 9,"Module", '1', 0, 'C', 0);

		                        $this->Cell(8, 9,"QTY", '1', 0, 'C', 0);

		                        $this->Cell(8, 9,"FOC", '1', 0, 'C', 0);

		                        $this->Cell(17, 9,"Unit Price", '1', 0, 'C', 0);

		                        $this->Cell(17, 9,"Last Price", '1', 0, 'C', 0);

		                        $this->Cell(15, 9,"Sales Price", '1', 0, 'C', 0);

		                        //$this->Cell(10, 9,"Sales Pro.", '1', 0, 'C', 0);

		                        $this->Cell(15, 9,"Discount", '1', 0, 'C', 0);

		                        //$this->Cell(10, 9,"Profit", '1', 0, 'C', 0);

		                        $this->Cell(10, 9,"L.P.M", '1', 0, 'C', 0);

		                        $this->Cell(10, 9,"S.P.M", '1', 0, 'C', 0);

		                        $this->Cell(20, 9,"Amount", '1', 0, 'C', 0);

							    $this->Ln();

		                        /*$this->MultiCell(5, 9, "No", $border=1, $align='C', $fill=false, $ln=0, $x='5', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(25, 9, "Item Code", $border=1, $align='C', $fill=false, $ln=0, $x='10', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(30, 9, "Item Description", $border=1, $align='C', $fill=false, $ln=0, $x='35', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(10, 9, "Module", $border=1, $align='C', $fill=false, $ln=0, $x='75', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(5, 9, "QTY", $border=1, $align='C', $fill=false, $ln=0, $x='85', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=6, $valign='M', $fitcell=false);
		                        $this->MultiCell(10, 9, "FOC", $border=1, $align='C', $fill=false, $ln=0, $x='90', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=false, $maxh=6, $valign='M', $fitcell=false);
		                        $this->MultiCell(15, 9, "Unit Price", $border=1, $align='C', $fill=false, $ln=0, $x='100', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Last Price", $border=1, $align='C', $fill=false, $ln=0, $x='115', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Sales Price", $border=1, $align='C', $fill=false, $ln=0, $x='130', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Sales Pro.", $border=1, $align='C', $fill=false, $ln=0, $x='145', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(15, 9, "Discount", $border=1, $align='C', $fill=false, $ln=0, $x='160', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(10, 9, "Profit", $border=1, $align='C', $fill=false, $ln=0, $x='175', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                        $this->MultiCell(20, 9, "Amount", $border=1, $align='C', $fill=false, $ln=0, $x='185', $y='60', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=9, $valign='M', $fitcell=true);
		                 		*/
			               	}

						}



								if($type=="t_price_change_sum"){
							if($count>1){	


					 			$this->SetY(34);
		                        $this->SetFont('helvetica','IB',8);
		                        $this->Cell(10, 6,"No", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(55, 6,"Description", '1', 0, 'C', 0);
		                        $this->Cell(23, 6,"Model", '1', 0, 'C', 0);
		                        $this->Cell(14, 6,"Cost", '1', 0, 'C', 0);
		                        $this->Cell(14, 6,"L.Price", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"N.L.Price", '1', 0, 'C', 0);
		                        $this->Cell(14, 6,"M.Price", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"N.Max Price", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    		$this->SetY(45);
		                        $this->SetFont('helvetica','IB',8);
		                        $this->Cell(10, 6,"No", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(55, 6,"Description", '1', 0, 'C', 0);
		                        $this->Cell(23, 6,"Model", '1', 0, 'C', 0);
		                        $this->Cell(14, 6,"Cost", '1', 0, 'C', 0);
		                        $this->Cell(14, 6,"L.Price", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"N.L.Price", '1', 0, 'C', 0);
		                        $this->Cell(14, 6,"M.Price", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"N.M Price", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}

								if($type=="t_quotation_sum"){
							if($count>1){	


					 			$this->SetY(34);
		                        $this->SetFont('helvetica','IB',8);
		                        $this->Cell(10, 6,"No", '1', 0, 'C', 0);
		                        $this->Cell(30, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(55, 6,"Description", '1', 0, 'C', 0);
		                        //$this->Cell(23, 6,"Model", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Price", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"Dis(%)", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Amount", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}else{
		                    	$this->SetY(45);
		                        $this->SetFont('helvetica','IB',8);
		                        $this->Cell(10, 6,"No", '1', 0, 'C', 0);
		                        $this->Cell(30, 6,"Code", '1', 0, 'C', 0);
								$this->Cell(55, 6,"Description", '1', 0, 'C', 0);
		                        //$this->Cell(23, 6,"Model", '1', 0, 'C', 0);
		                        $this->Cell(10, 6,"QTY", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Price", '1', 0, 'C', 0);
		                        $this->Cell(15, 6,"Dis(%)", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Discount", '1', 0, 'C', 0);
		                        $this->Cell(20, 6,"Amount", '1', 0, 'C', 0);
		                        $this->Ln();
		                    	}
						}

	}

	/**
	 * This method is used to render the page footer.
	 * It is automatically called by AddPage() and could be overwritten in your own inherited class.
	 * @public
	 */
	public function Footer() {
		$cur_y = $this->y;
		$this->SetTextColor(0, 0, 0);
		//set style for cell border
		$line_width = 0.85 / $this->k;
		$this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(152, 89, 24)));
		//print document barcode
		$barcode = $this->getBarcode();
		if (!empty($barcode)) {
			$this->Ln($line_width);
			$barcode_width = round(($this->w - $this->original_lMargin - $this->original_rMargin) / 3);
			$style = array(
				'position' => $this->rtl?'R':'L',
				'align' => $this->rtl?'R':'L',
				'stretch' => false,
				'fitwidth' => true,
				'cellfitalign' => '',
				'border' => false,
				'padding' => 0,
				'fgcolor' => array(0,0,0),
				'bgcolor' => false,
				'text' => false
			);
			$this->write1DBarcode($barcode, 'C128', '', $cur_y + $line_width, '', (($this->footer_margin / 3) - $line_width), 0.3, $style, '');
		}
		if (empty($this->pagegroups)) {
			$pagenumtxt = $this->l['w_page'].' '.$this->getAliasNumPage().' / '.$this->getAliasNbPages();
		} else {
			$pagenumtxt = $this->l['w_page'].' '.$this->getPageNumGroupAlias().' / '.$this->getPageGroupAlias();
		}
		$this->SetY($cur_y);
		//Print page number
		if ($this->getRTL()) {
			$this->SetX($this->original_rMargin);
			$this->Cell(0, 0, $pagenumtxt, 'T', 0, 'L');
		} else {
			$this->SetX($this->original_lMargin);
			$this->Cell(0, 0, $this->getAliasRightShift().$pagenumtxt, 'T', 0, 'R');
		}
	}

	/**
	 * This method is used to render the page header.
	 * @protected
	 * @since 4.0.012 (2008-07-24)
	 */
	protected function setHeader() {
		if (!$this->print_header) {
			return;
		}
                $type=$this->print_type;
                            
                
		$this->InHeader = true;
		$this->setGraphicVars($this->default_graphic_vars);
		$temp_thead = $this->thead;
		$temp_theadMargins = $this->theadMargins;
		$lasth = $this->lasth;
		$this->_out('q');
		$this->rMargin = $this->original_rMargin;
		$this->lMargin = $this->original_lMargin;
		$this->SetCellPadding(0);
		//set current position
		if ($this->rtl) {
			$this->SetXY($this->original_rMargin, $this->header_margin);
		} else {
			$this->SetXY($this->original_lMargin, $this->header_margin);
		}
		$this->SetFont($this->header_font[0], $this->header_font[1], $this->header_font[2]);
		
               

                $this->Header($type);
     
              ///  foreach($info as $ress){
		//$this->pdf->headerSet('gdfg','$ress->p_com_name','$ress->address01','$ress->Email','$ress->phone01','$from','$to');
              //  }
                
                
                
		//restore position
		if ($this->rtl) {
			$this->SetXY($this->original_rMargin, $this->tMargin);
		} else {
			$this->SetXY($this->original_lMargin, $this->tMargin);
		}
		$this->_out('Q');
		$this->lasth = $lasth;
		$this->thead = $temp_thead;
		$this->theadMargins = $temp_theadMargins;
		$this->newline = false;
		$this->InHeader = false;
	}

	/**
	 * This method is used to render the page footer.
	 * @protected
	 * @since 4.0.012 (2008-07-24)
	 */
	public function is_time($is_cur_time){
		$this->ttime=$is_cur_time;
	}

	protected function setFooter() {
		//Page footer
            
               $type=$this->print_type1;
            
            
		$this->InFooter = true;
		// save current graphic settings
		$gvars = $this->getGraphicVars();
		// mark this point
		$this->footerpos[$this->page] = $this->pagelen[$this->page];
		$this->_out("\n");
		if ($this->print_footer) {
			$this->setGraphicVars($this->default_graphic_vars);
			$this->current_column = 0;
			$this->num_columns = 1;
			$temp_thead = $this->thead;
			$temp_theadMargins = $this->theadMargins;
			$lasth = $this->lasth;
			$this->_out('q');
			$this->rMargin = $this->original_rMargin;
			$this->lMargin = $this->original_lMargin;
			$this->SetCellPadding(0);
			//set current position
			$footer_y = $this->h - $this->footer_margin;
			if ($this->rtl) {
				$this->SetXY($this->original_rMargin, $footer_y);
			} else {
				$this->SetXY($this->original_lMargin, $footer_y);
			}
			$this->SetFont($this->footer_font[0], $this->footer_font[1], $this->footer_font[2]);
                                               
                        
                        $pgWdith=$this->getPageWidth();
                        $this->SetY(-11);$y=$this->GetY();$this->line(10,$y,$pgWdith-15,$y);
                        $this->SetFont('helvetica', '', 6.5);
                        
						$this->Cell(0, 5, date('d-m-Y  H:i:s a'), 0, false, 'L', 0, '', 0, false, 'T', 'M');
                        $this->Cell(0, 5, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
                        $this->Ln();
                        $this->Cell(0, 5, 'Copyrights  Soft-Master Technologies (Pvt) Ltd.  (0812-204130, 0814-921402,  0773-889082/3)', 0, false, 'L', 0, '', 0, false, 'T', 'M');
                        
                        $count=$this->PageNo();
                        //echo $count;
                        
                        if ($count>1)
                        {
                            
                          $this->writeHTML("",true,false,true,false,'');
                        }
                        
                        
                        //if($this->PageNo()='2')
                        //{
                       // if($this->getAliasNumPage()=='2')
                        //{   
                        //$this->footerSet();
                        ///}
			//restore position
                        
                       
                        
			if ($this->rtl) {
				$this->SetXY($this->original_rMargin, $this->tMargin);
			} else {
				$this->SetXY($this->original_lMargin, $this->tMargin);
			}
			$this->_out('Q');
			$this->lasth = $lasth;
			$this->thead = $temp_thead;
			$this->theadMargins = $temp_theadMargins;
                        
		}   
                
                
		// restore graphic settings
		$this->setGraphicVars($gvars);
		$this->current_column = $gvars['current_column'];
		$this->num_columns = $gvars['num_columns'];
		// calculate footer length
               
		$this->footerlen[$this->page] = $this->pagelen[$this->page] - $this->footerpos[$this->page] + 1;
                $this->InFooter = false;
               
		       
	}

	/**
	 * Check if we are on the page body (excluding page header and footer).
	 * @return true if we are not in page header nor in page footer, false otherwise.
	 * @protected
	 * @since 5.9.091 (2011-06-15)
	 */
	protected function inPageBody() {
		return (($this->InHeader === false) AND ($this->InFooter === false));
	}

	/**
	 * This method is used to render the table header on new page (if any).
	 * @protected
	 * @since 4.5.030 (2009-03-25)
	 */
	protected function setTableHeader() {
		if ($this->num_columns > 1) {
			// multi column mode
			return;
		}
		if (isset($this->theadMargins['top'])) {
			// restore the original top-margin
			$this->tMargin = $this->theadMargins['top'];
			$this->pagedim[$this->page]['tm'] = $this->tMargin;
			$this->y = $this->tMargin;
		}
		if (!$this->empty_string($this->thead) AND (!$this->inthead)) {
			// set margins
			$prev_lMargin = $this->lMargin;
			$prev_rMargin = $this->rMargin;
			$prev_cell_padding = $this->cell_padding;
			$this->lMargin = $this->theadMargins['lmargin'] + ($this->pagedim[$this->page]['olm'] - $this->pagedim[$this->theadMargins['page']]['olm']);
			$this->rMargin = $this->theadMargins['rmargin'] + ($this->pagedim[$this->page]['orm'] - $this->pagedim[$this->theadMargins['page']]['orm']);
			$this->cell_padding = $this->theadMargins['cell_padding'];
			if ($this->rtl) {
				$this->x = $this->w - $this->rMargin;
			} else {
				$this->x = $this->lMargin;
			}
			// account for special "cell" mode
			if ($this->theadMargins['cell']) {
				if ($this->rtl) {
					$this->x -= $this->cell_padding['R'];
				} else {
					$this->x += $this->cell_padding['L'];
				}
			}
			// print table header
			$this->writeHTML($this->thead, false, false, false, false, '');
			// set new top margin to skip the table headers
			if (!isset($this->theadMargins['top'])) {
				$this->theadMargins['top'] = $this->tMargin;
			}
			// store end of header position
			if (!isset($this->columns[0]['th'])) {
				$this->columns[0]['th'] = array();
			}
			$this->columns[0]['th']['\''.$this->page.'\''] = $this->y;
			$this->tMargin = $this->y;
			$this->pagedim[$this->page]['tm'] = $this->tMargin;
			$this->lasth = 0;
			$this->lMargin = $prev_lMargin;
			$this->rMargin = $prev_rMargin;
			$this->cell_padding = $prev_cell_padding;
		}
	}

	/**
	 * Returns the current page number.
	 * @return int page number
	 * @public
	 * @since 1.0
	 * @see getAliasNbPages()
	 */
	public function PageNo() {
		return $this->page;
	}

	/**
	 * Defines a new spot color.
	 * It can be expressed in RGB components or gray scale.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $name (string) Full name of the spot color.
	 * @param $c (float) Cyan color for CMYK. Value between 0 and 100.
	 * @param $m (float) Magenta color for CMYK. Value between 0 and 100.
	 * @param $y (float) Yellow color for CMYK. Value between 0 and 100.
	 * @param $k (float) Key (Black) color for CMYK. Value between 0 and 100.
	 * @public
	 * @since 4.0.024 (2008-09-12)
	 * @see SetDrawSpotColor(), SetFillSpotColor(), SetTextSpotColor()
	 */
	public function AddSpotColor($name, $c, $m, $y, $k) {
		if (!isset($this->spot_colors[$name])) {
			$i = (1 + count($this->spot_colors));
			$this->spot_colors[$name] = array('C' => $c, 'M' => $m, 'Y' => $y, 'K' => $k, 'name' => $name, 'i' => $i);
		}
	}

	/**
	 * Return the Spot color array.
	 * @param $name (string) Name of the spot color.
	 * @return (array) Spot color array or false if not defined.
	 * @public
	 * @since 5.9.125 (2011-10-03)
	 */
	public function getSpotColor($name) {
		if (isset($this->spot_colors[$name])) {
			return $this->spot_colors[$name];
		}
		$color = preg_replace('/[\s]*/', '', $name); // remove extra spaces
		$color = strtolower($color);
		if (isset($this->spotcolor[$color])) {
			$this->AddSpotColor($this->spotcolor[$color][4], $this->spotcolor[$color][0], $this->spotcolor[$color][1], $this->spotcolor[$color][2], $this->spotcolor[$color][3]);
			return $this->spot_colors[$this->spotcolor[$color][4]];
		}
		return false;
	}

	/**
	 * Set the spot color for the specified type ('draw', 'fill', 'text').
	 * @param $type (string) Type of object affected by this color: ('draw', 'fill', 'text').
	 * @param $name (string) Name of the spot color.
	 * @param $tint (float) Intensity of the color (from 0 to 100 ; 100 = full intensity by default).
	 * @return (string) PDF color command.
	 * @public
	 * @since 5.9.125 (2011-10-03)
	 */
	public function setSpotColor($type, $name, $tint=100) {
		$spotcolor = $this->getSpotColor($name);
		if ($spotcolor === false) {
			$this->Error('Undefined spot color: '.$name.', you must add it on the spotcolors.php file.');
		}
		$tint = (max(0, min(100, $tint)) / 100);
		$pdfcolor = sprintf('/CS%d ', $this->spot_colors[$name]['i']);
		switch ($type) {
			case 'draw': {
				$pdfcolor .= sprintf('CS %F SCN', $tint);
				$this->DrawColor = $pdfcolor;
				$this->strokecolor = $spotcolor;
				break;
			}
			case 'fill': {
				$pdfcolor .= sprintf('cs %F scn', $tint);
				$this->FillColor = $pdfcolor;
				$this->bgcolor = $spotcolor;
				break;
			}
			case 'text': {
				$pdfcolor .= sprintf('cs %F scn', $tint);
				$this->TextColor = $pdfcolor;
				$this->fgcolor = $spotcolor;
				break;
			}
		}
		$this->ColorFlag = ($this->FillColor != $this->TextColor);
		if ($this->page > 0) {
			$this->_out($pdfcolor);
		}
		if ($this->inxobj) {
			// we are inside an XObject template
			$this->xobjects[$this->xobjid]['spot_colors'][$name] = $this->spot_colors[$name];
		}
		return $pdfcolor;
	}

	/**
	 * Defines the spot color used for all drawing operations (lines, rectangles and cell borders).
	 * @param $name (string) Name of the spot color.
	 * @param $tint (float) Intensity of the color (from 0 to 100 ; 100 = full intensity by default).
	 * @public
	 * @since 4.0.024 (2008-09-12)
	 * @see AddSpotColor(), SetFillSpotColor(), SetTextSpotColor()
	 */
	public function SetDrawSpotColor($name, $tint=100) {
		$this->setSpotColor('draw', $name, $tint);
	}

	/**
	 * Defines the spot color used for all filling operations (filled rectangles and cell backgrounds).
	 * @param $name (string) Name of the spot color.
	 * @param $tint (float) Intensity of the color (from 0 to 100 ; 100 = full intensity by default).
	 * @public
	 * @since 4.0.024 (2008-09-12)
	 * @see AddSpotColor(), SetDrawSpotColor(), SetTextSpotColor()
	 */
	public function SetFillSpotColor($name, $tint=100) {
		$this->setSpotColor('fill', $name, $tint);
	}

	/**
	 * Defines the spot color used for text.
	 * @param $name (string) Name of the spot color.
	 * @param $tint (int) Intensity of the color (from 0 to 100 ; 100 = full intensity by default).
	 * @public
	 * @since 4.0.024 (2008-09-12)
	 * @see AddSpotColor(), SetDrawSpotColor(), SetFillSpotColor()
	 */
	public function SetTextSpotColor($name, $tint=100) {
		$this->setSpotColor('text', $name, $tint);
	}

	/**
	 * Set the color array for the specified type ('draw', 'fill', 'text').
	 * It can be expressed in RGB, CMYK or GRAY SCALE components.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $type (string) Type of object affected by this color: ('draw', 'fill', 'text').
	 * @param $color (array) Array of colors (1=gray, 3=RGB, 4=CMYK or 5=spotcolor=CMYK+name values).
	 * @param $ret (boolean) If true do not send the PDF command.
	 * @return (string) The PDF command or empty string.
	 * @public
	 * @since 3.1.000 (2008-06-11)
	 */
	public function setColorArray($type, $color, $ret=false) {
		if (is_array($color)) {
			$color = array_values($color);
			// component: grey, RGB red or CMYK cyan
			$c = isset($color[0]) ? $color[0] : -1;
			// component: RGB green or CMYK magenta
			$m = isset($color[1]) ? $color[1] : -1;
			// component: RGB blue or CMYK yellow
			$y = isset($color[2]) ? $color[2] : -1;
			// component: CMYK black
			$k = isset($color[3]) ? $color[3] : -1;
			// color name
			$name = isset($color[4]) ? $color[4] : '';
			if ($c >= 0) {
				return $this->setColor($type, $c, $m, $y, $k, $ret, $name);
			}
		}
		return '';
	}

	/**
	 * Defines the color used for all drawing operations (lines, rectangles and cell borders).
	 * It can be expressed in RGB, CMYK or GRAY SCALE components.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $color (array) Array of colors (1, 3 or 4 values).
	 * @param $ret (boolean) If true do not send the PDF command.
	 * @return string the PDF command
	 * @public
	 * @since 3.1.000 (2008-06-11)
	 * @see SetDrawColor()
	 */
	public function SetDrawColorArray($color, $ret=false) {
		return $this->setColorArray('draw', $color, $ret);
	}

	/**
	 * Defines the color used for all filling operations (filled rectangles and cell backgrounds).
	 * It can be expressed in RGB, CMYK or GRAY SCALE components.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $color (array) Array of colors (1, 3 or 4 values).
	 * @param $ret (boolean) If true do not send the PDF command.
	 * @public
	 * @since 3.1.000 (2008-6-11)
	 * @see SetFillColor()
	 */
	public function SetFillColorArray($color, $ret=false) {
		return $this->setColorArray('fill', $color, $ret);
	}

	/**
	 * Defines the color used for text. It can be expressed in RGB components or gray scale.
	 * The method can be called before the first page is created and the value is retained from page to page.
	 * @param $color (array) Array of colors (1, 3 or 4 values).
	 * @param $ret (boolean) If true do not send the PDF command.
	 * @public
	 * @since 3.1.000 (2008-6-11)
	 * @see SetFillColor()
	 */
	public function SetTextColorArray($color, $ret=false) {
		return $this->setColorArray('text', $color, $ret);
	}

	/**
	 * Defines the color used by the specified type ('draw', 'fill', 'text').
	 * @param $type (string) Type of object affected by this color: ('draw', 'fill', 'text').
	 * @param $col1 (float) GRAY level for single color, or Red color for RGB (0-255), or CYAN color for CMYK (0-100).
	 * @param $col2 (float) GREEN color for RGB (0-255), or MAGENTA color for CMYK (0-100).
	 * @param $col3 (float) BLUE color for RGB (0-255), or YELLOW color for CMYK (0-100).
	 * @param $col4 (float) KEY (BLACK) color for CMYK (0-100).
	 * @param $ret (boolean) If true do not send the command.
	 * @param $name (string) spot color name (if any)
	 * @return (string) The PDF command or empty string.
	 * @public
	 * @since 5.9.125 (2011-10-03)
	 */
	public function setColor($type, $col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name='') {
		// set default values
		if (!is_numeric($col1)) {
			$col1 = 0;
		}
		if (!is_numeric($col2)) {
			$col2 = -1;
		}
		if (!is_numeric($col3)) {
			$col3 = -1;
		}
		if (!is_numeric($col4)) {
			$col4 = -1;
		}
		// set color by case
		$suffix = '';
		if (($col2 == -1) AND ($col3 == -1) AND ($col4 == -1)) {
			// Grey scale
			$col1 = max(0, min(255, $col1));
			$intcolor = array('G' => $col1);
			$pdfcolor = sprintf('%F ', ($col1 / 255));
			$suffix = 'g';
		} elseif ($col4 == -1) {
			// RGB
			$col1 = max(0, min(255, $col1));
			$col2 = max(0, min(255, $col2));
			$col3 = max(0, min(255, $col3));
			$intcolor = array('R' => $col1, 'G' => $col2, 'B' => $col3);
			$pdfcolor = sprintf('%F %F %F ', ($col1 / 255), ($col2 / 255), ($col3 / 255));
			$suffix = 'rg';
		} else {
			$col1 = max(0, min(100, $col1));
			$col2 = max(0, min(100, $col2));
			$col3 = max(0, min(100, $col3));
			$col4 = max(0, min(100, $col4));
			if (empty($name)) {
				// CMYK
				$intcolor = array('C' => $col1, 'M' => $col2, 'Y' => $col3, 'K' => $col4);
				$pdfcolor = sprintf('%F %F %F %F ', ($col1 / 100), ($col2 / 100), ($col3 / 100), ($col4 / 100));
				$suffix = 'k';
			} else {
				// SPOT COLOR
				$intcolor = array('C' => $col1, 'M' => $col2, 'Y' => $col3, 'K' => $col4, 'name' => $name);
				$this->AddSpotColor($name, $col1, $col2, $col3, $col4);
				$pdfcolor = $this->setSpotColor($type, $name, 100);
			}
		}
		switch ($type) {
			case 'draw': {
				$pdfcolor .= strtoupper($suffix);
				$this->DrawColor = $pdfcolor;
				$this->strokecolor = $intcolor;
				break;
			}
			case 'fill': {
				$pdfcolor .= $suffix;
				$this->FillColor = $pdfcolor;
				$this->bgcolor = $intcolor;
				break;
			}
			case 'text': {
				$pdfcolor .= $suffix;
				$this->TextColor = $pdfcolor;
				$this->fgcolor = $intcolor;
				break;
			}
		}
		$this->ColorFlag = ($this->FillColor != $this->TextColor);
		if (($type != 'text') AND ($this->page > 0)) {
			if (!$ret) {
				$this->_out($pdfcolor);
			}
			return $pdfcolor;
		}
		return '';
	}

	/**
	 * Convert a color array into a string representation.
	 * @param $c (array) Array of colors.
	 * @return (string) The color array representation.
	 * @protected
	 * @since 5.9.137 (2011-12-01)
	 */
	protected function getColorStringFromArray($c) {
		$c = array_values($c);
		$color = '[';
		switch (count($c)) {
			case 4: {
				// CMYK
				$color .= sprintf('%F %F %F %F', (max(0, min(100, floatval($c[0]))) / 100), (max(0, min(100, floatval($c[1]))) / 100), (max(0, min(100, floatval($c[2]))) / 100), (max(0, min(100, floatval($c[3]))) / 100));
				break;
			}
			case 3: {
				// RGB
				$color .= sprintf('%F %F %F', (max(0, min(255, floatval($c[0]))) / 255), (max(0, min(255, floatval($c[1]))) / 255), (max(0, min(255, floatval($c[2]))) / 255));
				break;
			}
			case 1: {
				// grayscale
				$color .= sprintf('%F', (max(0, min(255, floatval($c[0]))) / 255));
				break;
			}
		}
		$color .= ']';
		return $color;
	}

	/**
	 * Defines the color used for all drawing operations (lines, rectangles and cell borders). It can be expressed in RGB components or gray scale. The method can be called before the first page is created and the value is retained from page to page.
	 * @param $col1 (float) GRAY level for single color, or Red color for RGB (0-255), or CYAN color for CMYK (0-100).
	 * @param $col2 (float) GREEN color for RGB (0-255), or MAGENTA color for CMYK (0-100).
	 * @param $col3 (float) BLUE color for RGB (0-255), or YELLOW color for CMYK (0-100).
	 * @param $col4 (float) KEY (BLACK) color for CMYK (0-100).
	 * @param $ret (boolean) If true do not send the command.
	 * @param $name (string) spot color name (if any)
	 * @return string the PDF command
	 * @public
	 * @since 1.3
	 * @see SetDrawColorArray(), SetFillColor(), SetTextColor(), Line(), Rect(), Cell(), MultiCell()
	 */
	public function SetDrawColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name='') {
		return $this->setColor('draw', $col1, $col2, $col3, $col4, $ret, $name);
	}

	/**
	 * Defines the color used for all filling operations (filled rectangles and cell backgrounds). It can be expressed in RGB components or gray scale. The method can be called before the first page is created and the value is retained from page to page.
	 * @param $col1 (float) GRAY level for single color, or Red color for RGB (0-255), or CYAN color for CMYK (0-100).
	 * @param $col2 (float) GREEN color for RGB (0-255), or MAGENTA color for CMYK (0-100).
	 * @param $col3 (float) BLUE color for RGB (0-255), or YELLOW color for CMYK (0-100).
	 * @param $col4 (float) KEY (BLACK) color for CMYK (0-100).
	 * @param $ret (boolean) If true do not send the command.
	 * @param $name (string) Spot color name (if any).
	 * @return (string) The PDF command.
	 * @public
	 * @since 1.3
	 * @see SetFillColorArray(), SetDrawColor(), SetTextColor(), Rect(), Cell(), MultiCell()
	 */
	public function SetFillColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name='') {
		return $this->setColor('fill', $col1, $col2, $col3, $col4, $ret, $name);
	}

	/**
	 * Defines the color used for text. It can be expressed in RGB components or gray scale. The method can be called before the first page is created and the value is retained from page to page.
	 * @param $col1 (float) GRAY level for single color, or Red color for RGB (0-255), or CYAN color for CMYK (0-100).
	 * @param $col2 (float) GREEN color for RGB (0-255), or MAGENTA color for CMYK (0-100).
	 * @param $col3 (float) BLUE color for RGB (0-255), or YELLOW color for CMYK (0-100).
	 * @param $col4 (float) KEY (BLACK) color for CMYK (0-100).
	 * @param $ret (boolean) If true do not send the command.
	 * @param $name (string) Spot color name (if any).
	 * @return (string) Empty string.
	 * @public
	 * @since 1.3
	 * @see SetTextColorArray(), SetDrawColor(), SetFillColor(), Text(), Cell(), MultiCell()
	 */
	public function SetTextColor($col1=0, $col2=-1, $col3=-1, $col4=-1, $ret=false, $name='') {
		return $this->setColor('text', $col1, $col2, $col3, $col4, $ret, $name);
	}

	/**
	 * Returns the length of a string in user unit. A font must be selected.<br>
	 * @param $s (string) The string whose length is to be computed
	 * @param $fontname (string) Family font. It can be either a name defined by AddFont() or one of the standard families. It is also possible to pass an empty string, in that case, the current family is retained.
	 * @param $fontstyle (string) Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line-trough</li><li>O: overline</li></ul> or any combination. The default value is regular.
	 * @param $fontsize (float) Font size in points. The default value is the current size.
	 * @param $getarray (boolean) if true returns an array of characters widths, if false returns the total length.
	 * @return mixed int total string length or array of characted widths
	 * @author Nicola Asuni
	 * @public
	 * @since 1.2
	 */
	public function GetStringWidth($s, $fontname='', $fontstyle='', $fontsize=0, $getarray=false) {
		return $this->GetArrStringWidth($this->utf8Bidi($this->UTF8StringToArray($s), $s, $this->tmprtl), $fontname, $fontstyle, $fontsize, $getarray);
	}

	/**
	 * Returns the string length of an array of chars in user unit or an array of characters widths. A font must be selected.<br>
	 * @param $sa (string) The array of chars whose total length is to be computed
	 * @param $fontname (string) Family font. It can be either a name defined by AddFont() or one of the standard families. It is also possible to pass an empty string, in that case, the current family is retained.
	 * @param $fontstyle (string) Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line trough</li><li>O: overline</li></ul> or any combination. The default value is regular.
	 * @param $fontsize (float) Font size in points. The default value is the current size.
	 * @param $getarray (boolean) if true returns an array of characters widths, if false returns the total length.
	 * @return mixed int total string length or array of characted widths
	 * @author Nicola Asuni
	 * @public
	 * @since 2.4.000 (2008-03-06)
	 */
	public function GetArrStringWidth($sa, $fontname='', $fontstyle='', $fontsize=0, $getarray=false) {
		// store current values
		if (!$this->empty_string($fontname)) {
			$prev_FontFamily = $this->FontFamily;
			$prev_FontStyle = $this->FontStyle;
			$prev_FontSizePt = $this->FontSizePt;
			$this->SetFont($fontname, $fontstyle, $fontsize, '', 'default', false);
		}
		// convert UTF-8 array to Latin1 if required
		$sa = $this->UTF8ArrToLatin1($sa);
		$w = 0; // total width
		$wa = array(); // array of characters widths
		foreach ($sa as $ck => $char) {
			// character width
			$cw = $this->GetCharWidth($char, isset($sa[($ck + 1)]));
			$wa[] = $cw;
			$w += $cw;
		}
		// restore previous values
		if (!$this->empty_string($fontname)) {
			$this->SetFont($prev_FontFamily, $prev_FontStyle, $prev_FontSizePt, '', 'default', false);
		}
		if ($getarray) {
			return $wa;
		}
		return $w;
	}

	/**
	 * Returns the length of the char in user unit for the current font considering current stretching and spacing (tracking/kerning).
	 * @param $char (int) The char code whose length is to be returned
	 * @param $notlast (boolean) set to false for the latest character on string, true otherwise (default)
	 * @return float char width
	 * @author Nicola Asuni
	 * @public
	 * @since 2.4.000 (2008-03-06)
	 */
	public function GetCharWidth($char, $notlast=true) {
		// get raw width
		$chw = $this->getRawCharWidth($char);
		if (($this->font_spacing != 0) AND $notlast) {
			// increase/decrease font spacing
			$chw += $this->font_spacing;
		}
		if ($this->font_stretching != 100) {
			// fixed stretching mode
			$chw *= ($this->font_stretching / 100);
		}
		return $chw;
	}

	/**
	 * Returns the length of the char in user unit for the current font.
	 * @param $char (int) The char code whose length is to be returned
	 * @return float char width
	 * @author Nicola Asuni
	 * @public
	 * @since 5.9.000 (2010-09-28)
	 */
	public function getRawCharWidth($char) {
		if ($char == 173) {
			// SHY character will not be printed
			return (0);
		}
		if (isset($this->CurrentFont['cw'][$char])) {
			$w = $this->CurrentFont['cw'][$char];
		} elseif (isset($this->CurrentFont['dw'])) {
			// default width
			$w = $this->CurrentFont['dw'];
		} elseif (isset($this->CurrentFont['cw'][32])) {
			// default width
			$w = $this->CurrentFont['cw'][32];
		} else {
			$w = 600;
		}
		return ($w * $this->FontSize / 1000);
	}

	/**
	 * Returns the numbero of characters in a string.
	 * @param $s (string) The input string.
	 * @return int number of characters
	 * @public
	 * @since 2.0.0001 (2008-01-07)
	 */
	public function GetNumChars($s) {
		if ($this->isUnicodeFont()) {
			return count($this->UTF8StringToArray($s));
		}
		return strlen($s);
	}

	/**
	 * Fill the list of available fonts ($this->fontlist).
	 * @protected
	 * @since 4.0.013 (2008-07-28)
	 */
	protected function getFontsList() {
		$fontsdir = opendir($this->_getfontpath());
		while (($file = readdir($fontsdir)) !== false) {
			if (substr($file, -4) == '.php') {
				array_push($this->fontlist, strtolower(basename($file, '.php')));
			}
		}
		closedir($fontsdir);
	}

	/**
	 * Imports a TrueType, Type1, core, or CID0 font and makes it available.
	 * It is necessary to generate a font definition file first (read /fonts/utils/README.TXT).
	 * The definition file (and the font file itself when embedding) must be present either in the current directory or in the one indicated by K_PATH_FONTS if the constant is defined. If it could not be found, the error "Could not include font definition file" is generated.
	 * @param $family (string) Font family. The name can be chosen arbitrarily. If it is a standard family name, it will override the corresponding font.
	 * @param $style (string) Font style. Possible values are (case insensitive):<ul><li>empty string: regular (default)</li><li>B: bold</li><li>I: italic</li><li>BI or IB: bold italic</li></ul>
	 * @param $fontfile (string) The font definition file. By default, the name is built from the family and style, in lower case with no spaces.
	 * @return array containing the font data, or false in case of error.
	 * @param $subset (mixed) if true embedd only a subset of the font (stores only the information related to the used characters); if false embedd full font; if 'default' uses the default value set using setFontSubsetting(). This option is valid only for TrueTypeUnicode fonts. If you want to enable users to change the document, set this parameter to false. If you subset the font, the person who receives your PDF would need to have your same font in order to make changes to your PDF. The file size of the PDF would also be smaller because you are embedding only part of a font.
	 * @public
	 * @since 1.5
	 * @see SetFont(), setFontSubsetting()
	 */
	public function AddFont($family, $style='', $fontfile='', $subset='default') {
		if ($subset === 'default') {
			$subset = $this->font_subsetting;
		}
		if ($this->pdfa_mode) {
			$subset = false;
		}
		if ($this->empty_string($family)) {
			if (!$this->empty_string($this->FontFamily)) {
				$family = $this->FontFamily;
			} else {
				$this->Error('Empty font family');
			}
		}
		// move embedded styles on $style
		if (substr($family, -1) == 'I') {
			$style .= 'I';
			$family = substr($family, 0, -1);
		}
		if (substr($family, -1) == 'B') {
			$style .= 'B';
			$family = substr($family, 0, -1);
		}
		// normalize family name
		$family = strtolower($family);
		if ((!$this->isunicode) AND ($family == 'arial')) {
			$family = 'helvetica';
		}
		if (($family == 'symbol') OR ($family == 'zapfdingbats')) {
			$style = '';
		}
		if ($this->pdfa_mode AND (isset($this->CoreFonts[$family]))) {
			// all fonts must be embedded
			$family = 'pdfa'.$family;
		}
		$tempstyle = strtoupper($style);
		$style = '';
		// underline
		if (strpos($tempstyle, 'U') !== false) {
			$this->underline = true;
		} else {
			$this->underline = false;
		}
		// line-through (deleted)
		if (strpos($tempstyle, 'D') !== false) {
			$this->linethrough = true;
		} else {
			$this->linethrough = false;
		}
		// overline
		if (strpos($tempstyle, 'O') !== false) {
			$this->overline = true;
		} else {
			$this->overline = false;
		}
		// bold
		if (strpos($tempstyle, 'B') !== false) {
			$style .= 'B';
		}
		// oblique
		if (strpos($tempstyle, 'I') !== false) {
			$style .= 'I';
		}
		$bistyle = $style;
		$fontkey = $family.$style;
		$font_style = $style.($this->underline ? 'U' : '').($this->linethrough ? 'D' : '').($this->overline ? 'O' : '');
		$fontdata = array('fontkey' => $fontkey, 'family' => $family, 'style' => $font_style);
		// check if the font has been already added
		$fb = $this->getFontBuffer($fontkey);
		if ($fb !== false) {
			if ($this->inxobj) {
				// we are inside an XObject template
				$this->xobjects[$this->xobjid]['fonts'][$fontkey] = $fb['i'];
			}
			return $fontdata;
		}
		if (isset($type)) {
			unset($type);
		}
		if (isset($cw)) {
			unset($cw);
		}
		// get specified font directory (if any)
		$fontdir = false;
		if (!$this->empty_string($fontfile)) {
			$fontdir = dirname($fontfile);
			if ($this->empty_string($fontdir) OR ($fontdir == '.')) {
				$fontdir = '';
			} else {
				$fontdir .= '/';
			}
		}
		$missing_style = false; // true when the font style variation is missing
		// search and include font file
		if ($this->empty_string($fontfile) OR (!file_exists($fontfile))) {
			// build a standard filenames for specified font
			$tmp_fontfile = str_replace(' ', '', $family).strtolower($style).'.php';
			// search files on various directories
			if (($fontdir !== false) AND file_exists($fontdir.$tmp_fontfile)) {
				$fontfile = $fontdir.$tmp_fontfile;
			} elseif (file_exists($this->_getfontpath().$tmp_fontfile)) {
				$fontfile = $this->_getfontpath().$tmp_fontfile;
			} elseif (file_exists($tmp_fontfile)) {
				$fontfile = $tmp_fontfile;
			} elseif (!$this->empty_string($style)) {
				$missing_style = true;
				// try to remove the style part
				$tmp_fontfile = str_replace(' ', '', $family).'.php';
				if (($fontdir !== false) AND file_exists($fontdir.$tmp_fontfile)) {
					$fontfile = $fontdir.$tmp_fontfile;
				} elseif (file_exists($this->_getfontpath().$tmp_fontfile)) {
					$fontfile = $this->_getfontpath().$tmp_fontfile;
				} else {
					$fontfile = $tmp_fontfile;
				}
			}
		}
		// include font file
		if (file_exists($fontfile)) {
			include($fontfile);
		} else {
			$this->Error('Could not include font definition file: '.$family.'');
		}
		// check font parameters
		if ((!isset($type)) OR (!isset($cw))) {
			$this->Error('The font definition file has a bad format: '.$fontfile.'');
		}
		// SET default parameters
		if (!isset($file) OR $this->empty_string($file)) {
			$file = '';
		}
		if (!isset($enc) OR $this->empty_string($enc)) {
			$enc = '';
		}
		if (!isset($cidinfo) OR $this->empty_string($cidinfo)) {
			$cidinfo = array('Registry'=>'Adobe', 'Ordering'=>'Identity', 'Supplement'=>0);
			$cidinfo['uni2cid'] = array();
		}
		if (!isset($ctg) OR $this->empty_string($ctg)) {
			$ctg = '';
		}
		if (!isset($desc) OR $this->empty_string($desc)) {
			$desc = array();
		}
		if (!isset($up) OR $this->empty_string($up)) {
			$up = -100;
		}
		if (!isset($ut) OR $this->empty_string($ut)) {
			$ut = 50;
		}
		if (!isset($cw) OR $this->empty_string($cw)) {
			$cw = array();
		}
		if (!isset($dw) OR $this->empty_string($dw)) {
			// set default width
			if (isset($desc['MissingWidth']) AND ($desc['MissingWidth'] > 0)) {
				$dw = $desc['MissingWidth'];
			} elseif (isset($cw[32])) {
				$dw = $cw[32];
			} else {
				$dw = 600;
			}
		}
		++$this->numfonts;
		if ($type == 'core') {
			$name = $this->CoreFonts[$fontkey];
			$subset = false;
		} elseif (($type == 'TrueType') OR ($type == 'Type1')) {
			$subset = false;
		} elseif ($type == 'TrueTypeUnicode') {
			$enc = 'Identity-H';
		} elseif ($type == 'cidfont0') {
			if ($this->pdfa_mode) {
				$this->Error('All fonts must be embedded in PDF/A mode!');
			}
		} else {
			$this->Error('Unknow font type: '.$type.'');
		}
		// set name if unset
		if (!isset($name) OR empty($name)) {
			$name = $fontkey;
		}
		// create artificial font style variations if missing (only works with non-embedded fonts)
		if (($type != 'core') AND $missing_style) {
			// style variations
			$styles = array('' => '', 'B' => ',Bold', 'I' => ',Italic', 'BI' => ',BoldItalic');
			$name .= $styles[$bistyle];
			// artificial bold
			if (strpos($bistyle, 'B') !== false) {
				if (isset($desc['StemV'])) {
					// from normal to bold
					$desc['StemV'] = round($desc['StemV'] * 1.75);
				} else {
					// bold
					$desc['StemV'] = 123;
				}
			}
			// artificial italic
			if (strpos($bistyle, 'I') !== false) {
				if (isset($desc['ItalicAngle'])) {
					$desc['ItalicAngle'] -= 11;
				} else {
					$desc['ItalicAngle'] = -11;
				}
				if (isset($desc['Flags'])) {
					$desc['Flags'] |= 64; //bit 7
				} else {
					$desc['Flags'] = 64;
				}
			}
		}
		// initialize subsetchars to contain default ASCII values (0-255)
		$subsetchars = array_fill(0, 256, true);
		$this->setFontBuffer($fontkey, array('fontkey' => $fontkey, 'i' => $this->numfonts, 'type' => $type, 'name' => $name, 'desc' => $desc, 'up' => $up, 'ut' => $ut, 'cw' => $cw, 'dw' => $dw, 'enc' => $enc, 'cidinfo' => $cidinfo, 'file' => $file, 'ctg' => $ctg, 'subset' => $subset, 'subsetchars' => $subsetchars));
		if ($this->inxobj) {
			// we are inside an XObject template
			$this->xobjects[$this->xobjid]['fonts'][$fontkey] = $this->numfonts;
		}
		if (isset($diff) AND (!empty($diff))) {
			//Search existing encodings
			$d = 0;
			$nb = count($this->diffs);
			for ($i=1; $i <= $nb; ++$i) {
				if ($this->diffs[$i] == $diff) {
					$d = $i;
					break;
				}
			}
			if ($d == 0) {
				$d = $nb + 1;
				$this->diffs[$d] = $diff;
			}
			$this->setFontSubBuffer($fontkey, 'diff', $d);
		}
		if (!$this->empty_string($file)) {
			if (!isset($this->FontFiles[$file])) {
				if ((strcasecmp($type,'TrueType') == 0) OR (strcasecmp($type, 'TrueTypeUnicode') == 0)) {
					$this->FontFiles[$file] = array('length1' => $originalsize, 'fontdir' => $fontdir, 'subset' => $subset, 'fontkeys' => array($fontkey));
				} elseif ($type != 'core') {
					$this->FontFiles[$file] = array('length1' => $size1, 'length2' => $size2, 'fontdir' => $fontdir, 'subset' => $subset, 'fontkeys' => array($fontkey));
				}
			} else {
				// update fontkeys that are sharing this font file
				$this->FontFiles[$file]['subset'] = ($this->FontFiles[$file]['subset'] AND $subset);
				if (!in_array($fontkey, $this->FontFiles[$file]['fontkeys'])) {
					$this->FontFiles[$file]['fontkeys'][] = $fontkey;
				}
			}
		}
		return $fontdata;
	}

	/**
	 * Sets the font used to print character strings.
	 * The font can be either a standard one or a font added via the AddFont() method. Standard fonts use Windows encoding cp1252 (Western Europe).
	 * The method can be called before the first page is created and the font is retained from page to page.
	 * If you just wish to change the current font size, it is simpler to call SetFontSize().
	 * Note: for the standard fonts, the font metric files must be accessible. There are three possibilities for this:<ul><li>They are in the current directory (the one where the running script lies)</li><li>They are in one of the directories defined by the include_path parameter</li><li>They are in the directory defined by the K_PATH_FONTS constant</li></ul><br />
	 * @param $family (string) Family font. It can be either a name defined by AddFont() or one of the standard Type1 families (case insensitive):<ul><li>times (Times-Roman)</li><li>timesb (Times-Bold)</li><li>timesi (Times-Italic)</li><li>timesbi (Times-BoldItalic)</li><li>helvetica (Helvetica)</li><li>helveticab (Helvetica-Bold)</li><li>helveticai (Helvetica-Oblique)</li><li>helveticabi (Helvetica-BoldOblique)</li><li>courier (Courier)</li><li>courierb (Courier-Bold)</li><li>courieri (Courier-Oblique)</li><li>courierbi (Courier-BoldOblique)</li><li>symbol (Symbol)</li><li>zapfdingbats (ZapfDingbats)</li></ul> It is also possible to pass an empty string. In that case, the current family is retained.
	 * @param $style (string) Font style. Possible values are (case insensitive):<ul><li>empty string: regular</li><li>B: bold</li><li>I: italic</li><li>U: underline</li><li>D: line trough</li><li>O: overline</li></ul> or any combination. The default value is regular. Bold and italic styles do not apply to Symbol and ZapfDingbats basic fonts or other fonts when not defined.
	 * @param $size (float) Font size in points. The default value is the current size. If no size has been specified since the beginning of the document, the value taken is 12
	 * @param $fontfile (string) The font definition file. By default, the name is built from the family and style, in lower case with no spaces.
	 * @param $subset (mixed) if true embedd only a subset of the font (stores only the information related to the used characters); if false embedd full font; if 'default' uses the default value set using setFontSubsetting(). This option is valid only for TrueTypeUnicode fonts. If you want to enable users to change the document, set this parameter to false. If you subset the font, the person who receives your PDF would need to have your same font in order to make changes to your PDF. The file size of the PDF would also be smaller because you are embedding only part of a font.
	 * @param $out (boolean) if true output the font size command, otherwise only set the font properties.
	 * @author Nicola Asuni
	 * @public
	 * @since 1.0
	 * @see AddFont(), SetFontSize()
	 */
	public function SetFont($family, $style='', $size=null, $fontfile='', $subset='default', $out=true) {
		//Select a font; size given in points
		if ($size === null) {
			$size = $this->FontSizePt;
		}
		if ($size < 0) {
			$size = 0;
		}
		// try to add font (if not already added)
		$fontdata = $this->AddFont($family, $style, $fontfile, $subset);
		$this->FontFamily = $fontdata['family'];
		$this->FontStyle = $fontdata['style'];
		$this->CurrentFont = $this->getFontBuffer($fontdata['fontkey']);
		$this->SetFontSize($size, $out);
	}

	/**
	 * Defines the size of the current font.
	 * @param $size (float) The font size in points.
	 * @param $out (boolean) if true output the font size command, otherwise only set the font properties.
	 * @public
	 * @since 1.0
	 * @see SetFont()
	 */
	public function SetFontSize($size, $out=true) {
		// font size in points
		$this->FontSizePt = $size;
		// font size in user units
		$this->FontSize = $size / $this->k;
		// calculate some font metrics
		if (isset($this->CurrentFont['desc']['FontBBox'])) {
			$bbox = explode(' ', substr($this->CurrentFont['desc']['FontBBox'], 1, -1));
			$font_height = ((intval($bbox[3]) - intval($bbox[1])) * $size / 1000);
		} else {
			$font_height = $size * 1.219;
		}
		if (isset($this->CurrentFont['desc']['Ascent']) AND ($this->CurrentFont['desc']['Ascent'] > 0)) {
			$font_ascent = ($this->CurrentFont['desc']['Ascent'] * $size / 1000);
		}
		if (isset($this->CurrentFont['desc']['Descent']) AND ($this->CurrentFont['desc']['Descent'] <= 0)) {
			$font_descent = (- $this->CurrentFont['desc']['Descent'] * $size / 1000);
		}
		if (!isset($font_ascent) AND !isset($font_descent)) {
			// core font
			$font_ascent = 0.76 * $font_height;
			$font_descent = $font_height - $font_ascent;
		} elseif (!isset($font_descent)) {
			$font_descent = $font_height - $font_ascent;
		} elseif (!isset($font_ascent)) {
			$font_ascent = $font_height - $font_descent;
		}
		$this->FontAscent = ($font_ascent / $this->k);
		$this->FontDescent = ($font_descent / $this->k);
		if ($out AND ($this->page > 0) AND (isset($this->CurrentFont['i']))) {
			$this->_out(sprintf('BT /F%d %F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
		}
	}

	/**
	 * Returns the bounding box of the current font in user units.
	 * @return array
	 * @public
	 * @since 5.9.152 (2012-03-23)
	 */
	public function getFontBBox() {
		$result = array();
		if (isset($this->CurrentFont['desc']['FontBBox'])) {
			$bbox = explode(' ', substr($this->CurrentFont['desc']['FontBBox'], 1, -1));
			foreach ($bbox as $v) {
				$result[] = (intval($v) * $this->FontSize / 1000);
			}
		} else {
			// Find max width
			if (isset($this->CurrentFont['desc']['MaxWidth'])) {
				$maxw = (intval($this->CurrentFont['desc']['MaxWidth']) * $this->FontSize / 1000);
			} else {
				$maxw = 0;
				if (isset($this->CurrentFont['desc']['MissingWidth'])) {
					$maxw = max($maxw, $this->CurrentFont['desc']['MissingWidth']);
				}
				if (isset($this->CurrentFont['desc']['AvgWidth'])) {
					$maxw = max($maxw, $this->CurrentFont['desc']['AvgWidth']);
				}
				if (isset($this->CurrentFont['dw'])) {
					$maxw = max($maxw, $this->CurrentFont['dw']);
				}
				foreach ($this->CurrentFont['cw'] as $char => $w) {
					$maxw = max($maxw, $w);
				}
				if ($maxw == 0) {
					$maxw = 600;
				}
				$maxw = ($maxw * $this->FontSize / 1000);
			}
			$result = array(0, -$this->FontDescent, $maxw, $this->FontAscent);
		}
		return $result;
	}

	/**
	 * Return the font descent value
	 * @param $font (string) font name
	 * @param $style (string) font style
	 * @param $size (float) The size (in points)
	 * @return int font descent
	 * @public
	 * @author Nicola Asuni
	 * @since 4.9.003 (2010-03-30)
	 */
	public function getFontDescent($font, $style='', $size=0) {
		$fontdata = $this->AddFont($font, $style);
		$fontinfo = $this->getFontBuffer($fontdata['fontkey']);
		if (isset($fontinfo['desc']['Descent']) AND ($fontinfo['desc']['Descent'] <= 0)) {
			$descent = (- $fontinfo['desc']['Descent'] * $size / 1000);
		} else {
			$descent = 1.219 * 0.24 * $size;
		}
		return ($descent / $this->k);
	}

	/**
	 * Return the font ascent value
	 * @param $font (string) font name
	 * @param $style (string) font style
	 * @param $size (float) The size (in points)
	 * @return int font ascent
	 * @public
	 * @author Nicola Asuni
	 * @since 4.9.003 (2010-03-30)
	 */
	public function getFontAscent($font, $style='', $size=0) {
		$fontdata = $this->AddFont($font, $style);
		$fontinfo = $this->getFontBuffer($fontdata['fontkey']);
		if (isset($fontinfo['desc']['Ascent']) AND ($fontinfo['desc']['Ascent'] > 0)) {
			$ascent = ($fontinfo['desc']['Ascent'] * $size / 1000);
		} else {
			$ascent = 1.219 * 0.76 * $size;
		}
		return ($ascent / $this->k);
	}

	/**
	 * Return the font descent value
	 * @param $char (mixed) Character to check (integer value or string)
	 * @param $font (string) Font name (family name).
	 * @param $style (string) Font style.
	 * @return (boolean) true if the char is defined, false otherwise.
	 * @public
	 * @since 5.9.153 (2012-03-28)
	 */
	public function isCharDefined($char, $font='', $style='') {
		if (is_string($char)) {
			// get character code
			$char = $this->UTF8StringToArray($char);
			$char = $char[0];
		}
		if ($this->empty_string($font)) {
			$font = $this->FontFamily;
		}
		$fontdata = $this->AddFont($font, $style);
		$fontinfo = $this->getFontBuffer($fontdata['fontkey']);
		return (isset($fontinfo['cw'][intval($char)]));
	}

	/**
	 * Replace missing font characters on selected font with specified substitutions.
	 * @param $text (string) Text to process.
	 * @param $font (string) Font name (family name).
	 * @param $style (string) Font style.
	 * @param $subs (array) Array of possible character substitutions. The key is the character to check (integer value) and the value is a single intege value or an array of possible substitutes.
	 * @return (string) Processed text.
	 * @public
	 * @since 5.9.153 (2012-03-28)
	 */
	public function replaceMissingChars($text, $font='', $style='', $subs=array()) {
		if (empty($subs)) {
			return $text;
		}
		if ($this->empty_string($font)) {
			$font = $this->FontFamily;
		}
		$fontdata = $this->AddFont($font, $style);
		$fontinfo = $this->getFontBuffer($fontdata['fontkey']);
		$uniarr = $this->UTF8StringToArray($text);
		foreach ($uniarr as $k => $chr) {
			if (!isset($fontinfo['cw'][$chr])) {
				// this character is missing on the selected font
				if (isset($subs[$chr])) {
					// we have available substitutions
					if (is_array($subs[$chr])) {
						foreach($subs[$chr] as $s) {
							if (isset($fontinfo['cw'][$s])) {
								$uniarr[$k] = $s;
								break;
							}
						}
					} elseif (isset($fontinfo['cw'][$subs[$chr]])) {
						$uniarr[$k] = $subs[$chr];
					}
				}
			}
		}
		return $this->UniArrSubString($this->UTF8ArrayToUniArray($uniarr));
	}

	/**
	 * Defines the default monospaced font.
	 * @param $font (string) Font name.
	 * @public
	 * @since 4.5.025
	 */
	public function SetDefaultMonospacedFont($font) {
		$this->default_monospaced_font = $font;
	}

	/**
	 * Creates a new internal link and returns its identifier. An internal link is a clickable area which directs to another place within the document.<br />
	 * The identifier can then be passed to Cell(), Write(), Image() or Link(). The destination is defined with SetLink().
	 * @public
	 * @since 1.5
	 * @see Cell(), Write(), Image(), Link(), SetLink()
	 */
	public function AddLink() {
		//Create a new internal link
		$n = count($this->links) + 1;
		$this->links[$n] = array(0, 0);
		return $n;
	}

	/**
	 * Defines the page and position a link points to.
	 * @param $link (int) The link identifier returned by AddLink()
	 * @param $y (float) Ordinate of target position; -1 indicates the current position. The default value is 0 (top of page)
	 * @param $page (int) Number of target page; -1 indicates the current page. This is the default value
	 * @public
	 * @since 1.5
	 * @see AddLink()
	 */
	public function SetLink($link, $y=0, $page=-1) {
		if ($y == -1) {
			$y = $this->y;
		}
		if ($page == -1) {
			$page = $this->page;
		}
		$this->links[$link] = array($page, $y);
	}

	/**
	 * Puts a link on a rectangular area of the page.
	 * Text or image links are generally put via Cell(), Write() or Image(), but this method can be useful for instance to define a clickable area inside an image.
	 * @param $x (float) Abscissa of the upper-left corner of the rectangle
	 * @param $y (float) Ordinate of the upper-left corner of the rectangle
	 * @param $w (float) Width of the rectangle
	 * @param $h (float) Height of the rectangle
	 * @param $link (mixed) URL or identifier returned by AddLink()
	 * @param $spaces (int) number of spaces on the text to link
	 * @public
	 * @since 1.5
	 * @see AddLink(), Annotation(), Cell(), Write(), Image()
	 */
	public function Link($x, $y, $w, $h, $link, $spaces=0) {
		$this->Annotation($x, $y, $w, $h, $link, array('Subtype'=>'Link'), $spaces);
	}

	/**
	 * Puts a markup annotation on a rectangular area of the page.
	 * !!!!THE ANNOTATION SUPPORT IS NOT YET FULLY IMPLEMENTED !!!!
	 * @param $x (float) Abscissa of the upper-left corner of the rectangle
	 * @param $y (float) Ordinate of the upper-left corner of the rectangle
	 * @param $w (float) Width of the rectangle
	 * @param $h (float) Height of the rectangle
	 * @param $text (string) annotation text or alternate content
	 * @param $opt (array) array of options (see section 8.4 of PDF reference 1.7).
	 * @param $spaces (int) number of spaces on the text to link
	 * @public
	 * @since 4.0.018 (2008-08-06)
	 */
	public function Annotation($x, $y, $w, $h, $text, $opt=array('Subtype'=>'Text'), $spaces=0) {
		if ($this->inxobj) {
			// store parameters for later use on template
			$this->xobjects[$this->xobjid]['annotations'][] = array('x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'text' => $text, 'opt' => $opt, 'spaces' => $spaces);
			return;
		}
		if ($x === '') {
			$x = $this->x;
		}
		if ($y === '') {
			$y = $this->y;
		}
		// check page for no-write regions and adapt page margins if necessary
		list($x, $y) = $this->checkPageRegions($h, $x, $y);
		// recalculate coordinates to account for graphic transformations
		if (isset($this->transfmatrix) AND !empty($this->transfmatrix)) {
			for ($i=$this->transfmatrix_key; $i > 0; --$i) {
				$maxid = count($this->transfmatrix[$i]) - 1;
				for ($j=$maxid; $j >= 0; --$j) {
					$ctm = $this->transfmatrix[$i][$j];
					if (isset($ctm['a'])) {
						$x = $x * $this->k;
						$y = ($this->h - $y) * $this->k;
						$w = $w * $this->k;
						$h = $h * $this->k;
						// top left
						$xt = $x;
						$yt = $y;
						$x1 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];
						$y1 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];
						// top right
						$xt = $x + $w;
						$yt = $y;
						$x2 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];
						$y2 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];
						// bottom left
						$xt = $x;
						$yt = $y - $h;
						$x3 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];
						$y3 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];
						// bottom right
						$xt = $x + $w;
						$yt = $y - $h;
						$x4 = ($ctm['a'] * $xt) + ($ctm['c'] * $yt) + $ctm['e'];
						$y4 = ($ctm['b'] * $xt) + ($ctm['d'] * $yt) + $ctm['f'];
						// new coordinates (rectangle area)
						$x = min($x1, $x2, $x3, $x4);
						$y = max($y1, $y2, $y3, $y4);
						$w = (max($x1, $x2, $x3, $x4) - $x) / $this->k;
						$h = ($y - min($y1, $y2, $y3, $y4)) / $this->k;
						$x = $x / $this->k;
						$y = $this->h - ($y / $this->k);
					}
				}
			}
		}
		if ($this->page <= 0) {
			$page = 1;
		} else {
			$page = $this->page;
		}
		if (!isset($this->PageAnnots[$page])) {
			$this->PageAnnots[$page] = array();
		}
		++$this->n;
		$this->PageAnnots[$page][] = array('n' => $this->n, 'x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'txt' => $text, 'opt' => $opt, 'numspaces' => $spaces);
		if (!$this->pdfa_mode) {
			if ((($opt['Subtype'] == 'FileAttachment') OR ($opt['Subtype'] == 'Sound')) AND (!$this->empty_string($opt['FS'])) AND file_exists($opt['FS']) AND (!isset($this->embeddedfiles[basename($opt['FS'])]))) {
				++$this->n;
				$this->embeddedfiles[basename($opt['FS'])] = array('n' => $this->n, 'file' => $opt['FS']);
			}
		}
		// Add widgets annotation's icons
		if (isset($opt['mk']['i']) AND file_exists($opt['mk']['i'])) {
			$this->Image($opt['mk']['i'], '', '', 10, 10, '', '', '', false, 300, '', false, false, 0, false, true);
		}
		if (isset($opt['mk']['ri']) AND file_exists($opt['mk']['ri'])) {
			$this->Image($opt['mk']['ri'], '', '', 0, 0, '', '', '', false, 300, '', false, false, 0, false, true);
		}
		if (isset($opt['mk']['ix']) AND file_exists($opt['mk']['ix'])) {
			$this->Image($opt['mk']['ix'], '', '', 0, 0, '', '', '', false, 300, '', false, false, 0, false, true);
		}
	}

	/**
	 * Embedd the attached files.
	 * @since 4.4.000 (2008-12-07)
	 * @protected
	 * @see Annotation()
	 */
	protected function _putEmbeddedFiles() {
		if ($this->pdfa_mode) {
			// embedded files are not allowed in PDF/A mode
			return;
		}
		reset($this->embeddedfiles);
		foreach ($this->embeddedfiles as $filename => $filedata) {
			$data = file_get_contents($filedata['file']);
			$filter = '';
			if ($this->compress) {
				$data = gzcompress($data);
				$filter = ' /Filter /FlateDecode';
			}
			$stream = $this->_getrawstream($data, $filedata['n']);
			$out = $this->_getobj($filedata['n'])."\n";
			$out .= '<< /Type /EmbeddedFile'.$filter.' /Length '.strlen($stream).' >>';
			$out .= ' stream'."\n".$stream."\n".'endstream';
			$out .= "\n".'endobj';
			$this->_out($out);
		}
	}

	/**
	 * Prints a text cell at the specified position.
	 * This method allows to place a string precisely on the page.
	 * @param $x (float) Abscissa of the cell origin
	 * @param $y (float) Ordinate of the cell origin
	 * @param $txt (string) String to print
	 * @param $fstroke (int) outline size in user units (false = disable)
	 * @param $fclip (boolean) if true activate clipping mode (you must call StartTransform() before this function and StopTransform() to stop the clipping tranformation).
	 * @param $ffill (boolean) if true fills the text
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul>Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $ignore_min_height (boolean) if true ignore automatic minimum height value.
	 * @param $calign (string) cell vertical alignment relative to the specified Y value. Possible values are:<ul><li>T : cell top</li><li>A : font top</li><li>L : font baseline</li><li>D : font bottom</li><li>B : cell bottom</li></ul>
	 * @param $valign (string) text vertical alignment inside the cell. Possible values are:<ul><li>T : top</li><li>C : center</li><li>B : bottom</li></ul>
	 * @param $rtloff (boolean) if true uses the page top-left corner as origin of axis for $x and $y initial position.
	 * @public
	 * @since 1.0
	 * @see Cell(), Write(), MultiCell(), WriteHTML(), WriteHTMLCell()
	 */
	public function Text($x, $y, $txt, $fstroke=false, $fclip=false, $ffill=true, $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M', $rtloff=false) {
		$textrendermode = $this->textrendermode;
		$textstrokewidth = $this->textstrokewidth;
		$this->setTextRenderingMode($fstroke, $ffill, $fclip);
		$this->SetXY($x, $y, $rtloff);
		$this->Cell(0, 0, $txt, $border, $ln, $align, $fill, $link, $stretch, $ignore_min_height, $calign, $valign);
		// restore previous rendering mode
		$this->textrendermode = $textrendermode;
		$this->textstrokewidth = $textstrokewidth;
	}

	/**
	 * Whenever a page break condition is met, the method is called, and the break is issued or not depending on the returned value.
	 * The default implementation returns a value according to the mode selected by SetAutoPageBreak().<br />
	 * This method is called automatically and should not be called directly by the application.
	 * @return boolean
	 * @public
	 * @since 1.4
	 * @see SetAutoPageBreak()
	 */
	public function AcceptPageBreak() {
		if ($this->num_columns > 1) {
			// multi column mode
			if ($this->current_column < ($this->num_columns - 1)) {
				// go to next column
				$this->selectColumn($this->current_column + 1);
			} elseif ($this->AutoPageBreak) {
				// add a new page
				$this->AddPage();
				// set first column
				$this->selectColumn(0);
			}
			// avoid page breaking from checkPageBreak()
			return false;
		}
		return $this->AutoPageBreak;
	}

	/**
	 * Add page if needed.
	 * @param $h (float) Cell height. Default value: 0.
	 * @param $y (mixed) starting y position, leave empty for current position.
	 * @param $addpage (boolean) if true add a page, otherwise only return the true/false state
	 * @return boolean true in case of page break, false otherwise.
	 * @since 3.2.000 (2008-07-01)
	 * @protected
	 */
	protected function checkPageBreak($h=0, $y='', $addpage=true) {
		if ($this->empty_string($y)) {
			$y = $this->y;
		}
		$current_page = $this->page;
		if ((($y + $h) > $this->PageBreakTrigger) AND ($this->inPageBody()) AND ($this->AcceptPageBreak())) {
			if ($addpage) {
				//Automatic page break
				$x = $this->x;
				$this->AddPage($this->CurOrientation);
				$this->y = $this->tMargin;
				$oldpage = $this->page - 1;
				if ($this->rtl) {
					if ($this->pagedim[$this->page]['orm'] != $this->pagedim[$oldpage]['orm']) {
						$this->x = $x - ($this->pagedim[$this->page]['orm'] - $this->pagedim[$oldpage]['orm']);
					} else {
						$this->x = $x;
					}
				} else {
					if ($this->pagedim[$this->page]['olm'] != $this->pagedim[$oldpage]['olm']) {
						$this->x = $x + ($this->pagedim[$this->page]['olm'] - $this->pagedim[$oldpage]['olm']);
					} else {
						$this->x = $x;
					}
				}
			}
			return true;
		}
		if ($current_page != $this->page) {
			// account for columns mode
			return true;
		}
		return false;
	}

	/**
	 * Removes SHY characters from text.
	 * Unicode Data:<ul>
	 * <li>Name : SOFT HYPHEN, commonly abbreviated as SHY</li>
	 * <li>HTML Entity (decimal): "&amp;#173;"</li>
	 * <li>HTML Entity (hex): "&amp;#xad;"</li>
	 * <li>HTML Entity (named): "&amp;shy;"</li>
	 * <li>How to type in Microsoft Windows: [Alt +00AD] or [Alt 0173]</li>
	 * <li>UTF-8 (hex): 0xC2 0xAD (c2ad)</li>
	 * <li>UTF-8 character: chr(194).chr(173)</li>
	 * </ul>
	 * @param $txt (string) input string
	 * @return string without SHY characters.
	 * @public
	 * @since (4.5.019) 2009-02-28
	 */
	public function removeSHY($txt='') {
		$txt = preg_replace('/([\\xc2]{1}[\\xad]{1})/', '', $txt);
		if (!$this->isunicode) {
			$txt = preg_replace('/([\\xad]{1})/', '', $txt);
		}
		return $txt;
	}

	/**
	 * Prints a cell (rectangular area) with optional borders, background color and character string. The upper-left corner of the cell corresponds to the current position. The text can be aligned or centered. After the call, the current position moves to the right or to the next line. It is possible to put a link on the text.<br />
	 * If automatic page breaking is enabled and the cell goes beyond the limit, a page break is done before outputting.
	 * @param $w (float) Cell width. If 0, the cell extends up to the right margin.
	 * @param $h (float) Cell height. Default value: 0.
	 * @param $txt (string) String to print. Default value: empty string.
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul> Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $ignore_min_height (boolean) if true ignore automatic minimum height value.
	 * @param $calign (string) cell vertical alignment relative to the specified Y value. Possible values are:<ul><li>T : cell top</li><li>C : center</li><li>B : cell bottom</li><li>A : font top</li><li>L : font baseline</li><li>D : font bottom</li></ul>
	 * @param $valign (string) text vertical alignment inside the cell. Possible values are:<ul><li>T : top</li><li>C : center</li><li>B : bottom</li></ul>
	 * @public
	 * @since 1.0
	 * @see SetFont(), SetDrawColor(), SetFillColor(), SetTextColor(), SetLineWidth(), AddLink(), Ln(), MultiCell(), Write(), SetAutoPageBreak()
	 */
	public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M') {
		$prev_cell_margin = $this->cell_margin;
		$prev_cell_padding = $this->cell_padding;
		$this->adjustCellPadding($border);
		if (!$ignore_min_height) {
			$min_cell_height = ($this->FontSize * $this->cell_height_ratio) + $this->cell_padding['T'] + $this->cell_padding['B'];
			if ($h < $min_cell_height) {
				$h = $min_cell_height;
			}
		}
		$this->checkPageBreak($h + $this->cell_margin['T'] + $this->cell_margin['B']);
		$this->_out($this->getCellCode($w, $h, $txt, $border, $ln, $align, $fill, $link, $stretch, true, $calign, $valign));
		$this->cell_padding = $prev_cell_padding;
		$this->cell_margin = $prev_cell_margin;
	}

	/**
	 * Returns the PDF string code to print a cell (rectangular area) with optional borders, background color and character string. The upper-left corner of the cell corresponds to the current position. The text can be aligned or centered. After the call, the current position moves to the right or to the next line. It is possible to put a link on the text.<br />
	 * If automatic page breaking is enabled and the cell goes beyond the limit, a page break is done before outputting.
	 * @param $w (float) Cell width. If 0, the cell extends up to the right margin.
	 * @param $h (float) Cell height. Default value: 0.
	 * @param $txt (string) String to print. Default value: empty string.
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul>Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $ignore_min_height (boolean) if true ignore automatic minimum height value.
	 * @param $calign (string) cell vertical alignment relative to the specified Y value. Possible values are:<ul><li>T : cell top</li><li>C : center</li><li>B : cell bottom</li><li>A : font top</li><li>L : font baseline</li><li>D : font bottom</li></ul>
	 * @param $valign (string) text vertical alignment inside the cell. Possible values are:<ul><li>T : top</li><li>M : middle</li><li>B : bottom</li></ul>
	 * @return string containing cell code
	 * @protected
	 * @since 1.0
	 * @see Cell()
	 */
	protected function getCellCode($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M') {
		// replace 'NO-BREAK SPACE' (U+00A0) character with a simple space
		$txt = str_replace($this->unichr(160), ' ', $txt);
		$prev_cell_margin = $this->cell_margin;
		$prev_cell_padding = $this->cell_padding;
		$txt = $this->removeSHY($txt);
		$rs = ''; //string to be returned
		$this->adjustCellPadding($border);
		if (!$ignore_min_height) {
			$min_cell_height = ($this->FontSize * $this->cell_height_ratio) + $this->cell_padding['T'] + $this->cell_padding['B'];
			if ($h < $min_cell_height) {
				$h = $min_cell_height;
			}
		}
		$k = $this->k;
		// check page for no-write regions and adapt page margins if necessary
		list($this->x, $this->y) = $this->checkPageRegions($h, $this->x, $this->y);
		if ($this->rtl) {
			$x = $this->x - $this->cell_margin['R'];
		} else {
			$x = $this->x + $this->cell_margin['L'];
		}
		$y = $this->y + $this->cell_margin['T'];
		$prev_font_stretching = $this->font_stretching;
		$prev_font_spacing = $this->font_spacing;
		// cell vertical alignment
		switch ($calign) {
			case 'A': {
				// font top
				switch ($valign) {
					case 'T': {
						// top
						$y -= $this->cell_padding['T'];
						break;
					}
					case 'B': {
						// bottom
						$y -= ($h - $this->cell_padding['B'] - $this->FontAscent - $this->FontDescent);
						break;
					}
					default:
					case 'C':
					case 'M': {
						// center
						$y -= (($h - $this->FontAscent - $this->FontDescent) / 2);
						break;
					}
				}
				break;
			}
			case 'L': {
				// font baseline
				switch ($valign) {
					case 'T': {
						// top
						$y -= ($this->cell_padding['T'] + $this->FontAscent);
						break;
					}
					case 'B': {
						// bottom
						$y -= ($h - $this->cell_padding['B'] - $this->FontDescent);
						break;
					}
					default:
					case 'C':
					case 'M': {
						// center
						$y -= (($h + $this->FontAscent - $this->FontDescent) / 2);
						break;
					}
				}
				break;
			}
			case 'D': {
				// font bottom
				switch ($valign) {
					case 'T': {
						// top
						$y -= ($this->cell_padding['T'] + $this->FontAscent + $this->FontDescent);
						break;
					}
					case 'B': {
						// bottom
						$y -= ($h - $this->cell_padding['B']);
						break;
					}
					default:
					case 'C':
					case 'M': {
						// center
						$y -= (($h + $this->FontAscent + $this->FontDescent) / 2);
						break;
					}
				}
				break;
			}
			case 'B': {
				// cell bottom
				$y -= $h;
				break;
			}
			case 'C':
			case 'M': {
				// cell center
				$y -= ($h / 2);
				break;
			}
			default:
			case 'T': {
				// cell top
				break;
			}
		}
		// text vertical alignment
		switch ($valign) {
			case 'T': {
				// top
				$yt = $y + $this->cell_padding['T'];
				break;
			}
			case 'B': {
				// bottom
				$yt = $y + $h - $this->cell_padding['B'] - $this->FontAscent - $this->FontDescent;
				break;
			}
			default:
			case 'C':
			case 'M': {
				// center
				$yt = $y + (($h - $this->FontAscent - $this->FontDescent) / 2);
				break;
			}
		}
		$basefonty = $yt + $this->FontAscent;
		if ($this->empty_string($w) OR ($w <= 0)) {
			if ($this->rtl) {
				$w = $x - $this->lMargin;
			} else {
				$w = $this->w - $this->rMargin - $x;
			}
		}
		$s = '';
		// fill and borders
		if (is_string($border) AND (strlen($border) == 4)) {
			// full border
			$border = 1;
		}
		if ($fill OR ($border == 1)) {
			if ($fill) {
				$op = ($border == 1) ? 'B' : 'f';
			} else {
				$op = 'S';
			}
			if ($this->rtl) {
				$xk = (($x - $w) * $k);
			} else {
				$xk = ($x * $k);
			}
			$s .= sprintf('%F %F %F %F re %s ', $xk, (($this->h - $y) * $k), ($w * $k), (-$h * $k), $op);
		}
		// draw borders
		$s .= $this->getCellBorder($x, $y, $w, $h, $border);
		if ($txt != '') {
			$txt2 = $txt;
			if ($this->isunicode) {
				if (($this->CurrentFont['type'] == 'core') OR ($this->CurrentFont['type'] == 'TrueType') OR ($this->CurrentFont['type'] == 'Type1')) {
					$txt2 = $this->UTF8ToLatin1($txt2);
				} else {
					$unicode = $this->UTF8StringToArray($txt); // array of UTF-8 unicode values
					$unicode = $this->utf8Bidi($unicode, '', $this->tmprtl);
					if (defined('K_THAI_TOPCHARS') AND (K_THAI_TOPCHARS == true)) {
						// ---- Fix for bug #2977340 "Incorrect Thai characters position arrangement" ----
						// NOTE: this doesn't work with HTML justification
						// Symbols that could overlap on the font top (only works in LTR)
						$topchar = array(3611, 3613, 3615, 3650, 3651, 3652); // chars that extends on top
						$topsym = array(3633, 3636, 3637, 3638, 3639, 3655, 3656, 3657, 3658, 3659, 3660, 3661, 3662); // symbols with top position
						$numchars = count($unicode); // number of chars
						$unik = 0;
						$uniblock = array();
						$uniblock[$unik] = array();
						$uniblock[$unik][] = $unicode[0];
						// resolve overlapping conflicts by splitting the string in several parts
						for ($i = 1; $i < $numchars; ++$i) {
							// check if symbols overlaps at top
							if (in_array($unicode[$i], $topsym) AND (in_array($unicode[($i - 1)], $topsym) OR in_array($unicode[($i - 1)], $topchar))) {
								// move symbols to another array
								++$unik;
								$uniblock[$unik] = array();
								$uniblock[$unik][] = $unicode[$i];
								++$unik;
								$uniblock[$unik] = array();
								$unicode[$i] = 0x200b; // Unicode Character 'ZERO WIDTH SPACE' (DEC:8203, U+200B)
							} else {
								$uniblock[$unik][] = $unicode[$i];
							}
						}
						// ---- END OF Fix for bug #2977340
					}
					$txt2 = $this->arrUTF8ToUTF16BE($unicode, false);
				}
			}
			$txt2 = $this->_escape($txt2);
			// get current text width (considering general font stretching and spacing)
			$txwidth = $this->GetStringWidth($txt);
			$width = $txwidth;
			// check for stretch mode
			if ($stretch > 0) {
				// calculate ratio between cell width and text width
				if ($width <= 0) {
					$ratio = 1;
				} else {
					$ratio = (($w - $this->cell_padding['L'] - $this->cell_padding['R']) / $width);
				}
				// check if stretching is required
				if (($ratio < 1) OR (($ratio > 1) AND (($stretch % 2) == 0))) {
					// the text will be stretched to fit cell width
					if ($stretch > 2) {
						// set new character spacing
						$this->font_spacing += ($w - $this->cell_padding['L'] - $this->cell_padding['R'] - $width) / (max(($this->GetNumChars($txt) - 1), 1) * ($this->font_stretching / 100));
					} else {
						// set new horizontal stretching
						$this->font_stretching *= $ratio;
					}
					// recalculate text width (the text fills the entire cell)
					$width = $w - $this->cell_padding['L'] - $this->cell_padding['R'];
					// reset alignment
					$align = '';
				}
			}
			if ($this->font_stretching != 100) {
				// apply font stretching
				$rs .= sprintf('BT %F Tz ET ', $this->font_stretching);
			}
			if ($this->font_spacing != 0) {
				// increase/decrease font spacing
				$rs .= sprintf('BT %F Tc ET ', ($this->font_spacing * $this->k));
			}
			if ($this->ColorFlag AND ($this->textrendermode < 4)) {
				$s .= 'q '.$this->TextColor.' ';
			}
			// rendering mode
			$s .= sprintf('BT %d Tr %F w ET ', $this->textrendermode, $this->textstrokewidth);
			// count number of spaces
			$ns = substr_count($txt, chr(32));
			// Justification
			$spacewidth = 0;
			if (($align == 'J') AND ($ns > 0)) {
				if ($this->isUnicodeFont()) {
					// get string width without spaces
					$width = $this->GetStringWidth(str_replace(' ', '', $txt));
					// calculate average space width
					$spacewidth = -1000 * ($w - $width - $this->cell_padding['L'] - $this->cell_padding['R']) / ($ns?$ns:1) / $this->FontSize;
					if ($this->font_stretching != 100) {
						// word spacing is affected by stretching
						$spacewidth /= ($this->font_stretching / 100);
					}
					// set word position to be used with TJ operator
					$txt2 = str_replace(chr(0).chr(32), ') '.sprintf('%F', $spacewidth).' (', $txt2);
					$unicode_justification = true;
				} else {
					// get string width
					$width = $txwidth;
					// new space width
					$spacewidth = (($w - $width - $this->cell_padding['L'] - $this->cell_padding['R']) / ($ns?$ns:1)) * $this->k;
					if ($this->font_stretching != 100) {
						// word spacing (Tw) is affected by stretching
						$spacewidth /= ($this->font_stretching / 100);
					}
					// set word spacing
					$rs .= sprintf('BT %F Tw ET ', $spacewidth);
				}
				$width = $w - $this->cell_padding['L'] - $this->cell_padding['R'];
			}
			// replace carriage return characters
			$txt2 = str_replace("\r", ' ', $txt2);
			switch ($align) {
				case 'C': {
					$dx = ($w - $width) / 2;
					break;
				}
				case 'R': {
					if ($this->rtl) {
						$dx = $this->cell_padding['R'];
					} else {
						$dx = $w - $width - $this->cell_padding['R'];
					}
					break;
				}
				case 'L': {
					if ($this->rtl) {
						$dx = $w - $width - $this->cell_padding['L'];
					} else {
						$dx = $this->cell_padding['L'];
					}
					break;
				}
				case 'J':
				default: {
					if ($this->rtl) {
						$dx = $this->cell_padding['R'];
					} else {
						$dx = $this->cell_padding['L'];
					}
					break;
				}
			}
			if ($this->rtl) {
				$xdx = $x - $dx - $width;
			} else {
				$xdx = $x + $dx;
			}
			$xdk = $xdx * $k;
			// print text
			$s .= sprintf('BT %F %F Td [(%s)] TJ ET', $xdk, (($this->h - $basefonty) * $k), $txt2);
			if (isset($uniblock)) {
				// print overlapping characters as separate string
				$xshift = 0; // horizontal shift
				$ty = (($this->h - $basefonty + (0.2 * $this->FontSize)) * $k);
				$spw = (($w - $txwidth - $this->cell_padding['L'] - $this->cell_padding['R']) / ($ns?$ns:1));
				foreach ($uniblock as $uk => $uniarr) {
					if (($uk % 2) == 0) {
						// x space to skip
						if ($spacewidth != 0) {
							// justification shift
							$xshift += (count(array_keys($uniarr, 32)) * $spw);
						}
						$xshift += $this->GetArrStringWidth($uniarr); // + shift justification
					} else {
						// character to print
						$topchr = $this->arrUTF8ToUTF16BE($uniarr, false);
						$topchr = $this->_escape($topchr);
						$s .= sprintf(' BT %F %F Td [(%s)] TJ ET', ($xdk + ($xshift * $k)), $ty, $topchr);
					}
				}
			}
			if ($this->underline) {
				$s .= ' '.$this->_dounderlinew($xdx, $basefonty, $width);
			}
			if ($this->linethrough) {
				$s .= ' '.$this->_dolinethroughw($xdx, $basefonty, $width);
			}
			if ($this->overline) {
				$s .= ' '.$this->_dooverlinew($xdx, $basefonty, $width);
			}
			if ($this->ColorFlag AND ($this->textrendermode < 4)) {
				$s .= ' Q';
			}
			if ($link) {
				$this->Link($xdx, $yt, $width, ($this->FontAscent + $this->FontDescent), $link, $ns);
			}
		}
		// output cell
		if ($s) {
			// output cell
			$rs .= $s;
			if ($this->font_spacing != 0) {
				// reset font spacing mode
				$rs .= ' BT 0 Tc ET';
			}
			if ($this->font_stretching != 100) {
				// reset font stretching mode
				$rs .= ' BT 100 Tz ET';
			}
		}
		// reset word spacing
		if (!$this->isUnicodeFont() AND ($align == 'J')) {
			$rs .= ' BT 0 Tw ET';
		}
		// reset stretching and spacing
		$this->font_stretching = $prev_font_stretching;
		$this->font_spacing = $prev_font_spacing;
		$this->lasth = $h;
		if ($ln > 0) {
			//Go to the beginning of the next line
			$this->y = $y + $h + $this->cell_margin['B'];
			if ($ln == 1) {
				if ($this->rtl) {
					$this->x = $this->w - $this->rMargin;
				} else {
					$this->x = $this->lMargin;
				}
			}
		} else {
			// go left or right by case
			if ($this->rtl) {
				$this->x = $x - $w - $this->cell_margin['L'];
			} else {
				$this->x = $x + $w + $this->cell_margin['R'];
			}
		}
		$gstyles = ''.$this->linestyleWidth.' '.$this->linestyleCap.' '.$this->linestyleJoin.' '.$this->linestyleDash.' '.$this->DrawColor.' '.$this->FillColor."\n";
		$rs = $gstyles.$rs;
		$this->cell_padding = $prev_cell_padding;
		$this->cell_margin = $prev_cell_margin;
		return $rs;
	}

	/**
	 * Returns the code to draw the cell border
	 * @param $x (float) X coordinate.
	 * @param $y (float) Y coordinate.
	 * @param $w (float) Cell width.
	 * @param $h (float) Cell height.
	 * @param $brd (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @return string containing cell border code
	 * @protected
	 * @see SetLineStyle()
	 * @since 5.7.000 (2010-08-02)
	 */
	protected function getCellBorder($x, $y, $w, $h, $brd) {
		$s = ''; // string to be returned
		if (empty($brd)) {
			return $s;
		}
		if ($brd == 1) {
			$brd = array('LRTB' => true);
		}
		// calculate coordinates for border
		$k = $this->k;
		if ($this->rtl) {
			$xeL = ($x - $w) * $k;
			$xeR = $x * $k;
		} else {
			$xeL = $x * $k;
			$xeR = ($x + $w) * $k;
		}
		$yeL = (($this->h - ($y + $h)) * $k);
		$yeT = (($this->h - $y) * $k);
		$xeT = $xeL;
		$xeB = $xeR;
		$yeR = $yeT;
		$yeB = $yeL;
		if (is_string($brd)) {
			// convert string to array
			$slen = strlen($brd);
			$newbrd = array();
			for ($i = 0; $i < $slen; ++$i) {
				$newbrd[$brd[$i]] = array('cap' => 'square', 'join' => 'miter');
			}
			$brd = $newbrd;
		}
		if (isset($brd['mode'])) {
			$mode = $brd['mode'];
			unset($brd['mode']);
		} else {
			$mode = 'normal';
		}
		foreach ($brd as $border => $style) {
			if (is_array($style) AND !empty($style)) {
				// apply border style
				$prev_style = $this->linestyleWidth.' '.$this->linestyleCap.' '.$this->linestyleJoin.' '.$this->linestyleDash.' '.$this->DrawColor.' ';
				$s .= $this->SetLineStyle($style, true)."\n";
			}
			switch ($mode) {
				case 'ext': {
					$off = (($this->LineWidth / 2) * $k);
					$xL = $xeL - $off;
					$xR = $xeR + $off;
					$yT = $yeT + $off;
					$yL = $yeL - $off;
					$xT = $xL;
					$xB = $xR;
					$yR = $yT;
					$yB = $yL;
					$w += $this->LineWidth;
					$h += $this->LineWidth;
					break;
				}
				case 'int': {
					$off = ($this->LineWidth / 2) * $k;
					$xL = $xeL + $off;
					$xR = $xeR - $off;
					$yT = $yeT - $off;
					$yL = $yeL + $off;
					$xT = $xL;
					$xB = $xR;
					$yR = $yT;
					$yB = $yL;
					$w -= $this->LineWidth;
					$h -= $this->LineWidth;
					break;
				}
				case 'normal':
				default: {
					$xL = $xeL;
					$xT = $xeT;
					$xB = $xeB;
					$xR = $xeR;
					$yL = $yeL;
					$yT = $yeT;
					$yB = $yeB;
					$yR = $yeR;
					break;
				}
			}
			// draw borders by case
			if (strlen($border) == 4) {
				$s .= sprintf('%F %F %F %F re S ', $xT, $yT, ($w * $k), (-$h * $k));
			} elseif (strlen($border) == 3) {
				if (strpos($border,'B') === false) { // LTR
					$s .= sprintf('%F %F m ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= 'S ';
				} elseif (strpos($border,'L') === false) { // TRB
					$s .= sprintf('%F %F m ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= 'S ';
				} elseif (strpos($border,'T') === false) { // RBL
					$s .= sprintf('%F %F m ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= 'S ';
				} elseif (strpos($border,'R') === false) { // BLT
					$s .= sprintf('%F %F m ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= 'S ';
				}
			} elseif (strlen($border) == 2) {
				if ((strpos($border,'L') !== false) AND (strpos($border,'T') !== false)) { // LT
					$s .= sprintf('%F %F m ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= 'S ';
				} elseif ((strpos($border,'T') !== false) AND (strpos($border,'R') !== false)) { // TR
					$s .= sprintf('%F %F m ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= 'S ';
				} elseif ((strpos($border,'R') !== false) AND (strpos($border,'B') !== false)) { // RB
					$s .= sprintf('%F %F m ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= 'S ';
				} elseif ((strpos($border,'B') !== false) AND (strpos($border,'L') !== false)) { // BL
					$s .= sprintf('%F %F m ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= 'S ';
				} elseif ((strpos($border,'L') !== false) AND (strpos($border,'R') !== false)) { // LR
					$s .= sprintf('%F %F m ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= 'S ';
					$s .= sprintf('%F %F m ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= 'S ';
				} elseif ((strpos($border,'T') !== false) AND (strpos($border,'B') !== false)) { // TB
					$s .= sprintf('%F %F m ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= 'S ';
					$s .= sprintf('%F %F m ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= 'S ';
				}
			} else { // strlen($border) == 1
				if (strpos($border,'L') !== false) { // L
					$s .= sprintf('%F %F m ', $xL, $yL);
					$s .= sprintf('%F %F l ', $xT, $yT);
					$s .= 'S ';
				} elseif (strpos($border,'T') !== false) { // T
					$s .= sprintf('%F %F m ', $xT, $yT);
					$s .= sprintf('%F %F l ', $xR, $yR);
					$s .= 'S ';
				} elseif (strpos($border,'R') !== false) { // R
					$s .= sprintf('%F %F m ', $xR, $yR);
					$s .= sprintf('%F %F l ', $xB, $yB);
					$s .= 'S ';
				} elseif (strpos($border,'B') !== false) { // B
					$s .= sprintf('%F %F m ', $xB, $yB);
					$s .= sprintf('%F %F l ', $xL, $yL);
					$s .= 'S ';
				}
			}
			if (is_array($style) AND !empty($style)) {
				// reset border style to previous value
				$s .= "\n".$this->linestyleWidth.' '.$this->linestyleCap.' '.$this->linestyleJoin.' '.$this->linestyleDash.' '.$this->DrawColor."\n";
			}
		}
		return $s;
	}

	/**
	 * This method allows printing text with line breaks.
	 * They can be automatic (as soon as the text reaches the right border of the cell) or explicit (via the \n character). As many cells as necessary are output, one below the other.<br />
	 * Text can be aligned, centered or justified. The cell block can be framed and the background painted.
	 * @param $w (float) Width of cells. If 0, they extend up to the right margin of the page.
	 * @param $h (float) Cell minimum height. The cell extends automatically if needed.
	 * @param $txt (string) String to print
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align</li><li>C: center</li><li>R: right align</li><li>J: justification (default value when $ishtml=false)</li></ul>
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right</li><li>1: to the beginning of the next line [DEFAULT]</li><li>2: below</li></ul>
	 * @param $x (float) x position in user units
	 * @param $y (float) y position in user units
	 * @param $reseth (boolean) if true reset the last cell height (default true).
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $ishtml (boolean) INTERNAL USE ONLY -- set to true if $txt is HTML content (default = false). Never set this parameter to true, use instead writeHTMLCell() or writeHTML() methods.
	 * @param $autopadding (boolean) if true, uses internal padding and automatically adjust it to account for line width.
	 * @param $maxh (float) maximum height. It should be >= $h and less then remaining space to the bottom of the page, or 0 for disable this feature. This feature works only when $ishtml=false.
	 * @param $valign (string) Vertical alignment of text (requires $maxh = $h > 0). Possible values are:<ul><li>T: TOP</li><li>M: middle</li><li>B: bottom</li></ul>. This feature works only when $ishtml=false and the cell must fit in a single page.
	 * @param $fitcell (boolean) if true attempt to fit all the text within the cell by reducing the font size (do not work in HTML mode).
	 * @return int Return the number of cells or 1 for html mode.
	 * @public
	 * @since 1.3
	 * @see SetFont(), SetDrawColor(), SetFillColor(), SetTextColor(), SetLineWidth(), Cell(), Write(), SetAutoPageBreak()
	 */
	public function MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false) {
		$prev_cell_margin = $this->cell_margin;
		$prev_cell_padding = $this->cell_padding;
		// adjust internal padding
		$this->adjustCellPadding($border);
		$mc_padding = $this->cell_padding;
		$mc_margin = $this->cell_margin;
		$this->cell_padding['T'] = 0;
		$this->cell_padding['B'] = 0;
		$this->setCellMargins(0, 0, 0, 0);
		if ($this->empty_string($this->lasth) OR $reseth) {
			// reset row height
			$this->resetLastH();
		}
		if (!$this->empty_string($y)) {
			$this->SetY($y);
		} else {
			$y = $this->GetY();
		}
		$resth = 0;
		if (($h > 0) AND $this->inPageBody() AND (($y + $h + $mc_margin['T'] + $mc_margin['B']) > $this->PageBreakTrigger)) {
			// spit cell in more pages/columns
			$newh = ($this->PageBreakTrigger - $y);
			$resth = ($h - $newh); // cell to be printed on the next page/column
			$h = $newh;
		}
		// get current page number
		$startpage = $this->page;
		// get current column
		$startcolumn = $this->current_column;
		if (!$this->empty_string($x)) {
			$this->SetX($x);
		} else {
			$x = $this->GetX();
		}
		// check page for no-write regions and adapt page margins if necessary
		list($x, $y) = $this->checkPageRegions(0, $x, $y);
		// apply margins
		$oy = $y + $mc_margin['T'];
		if ($this->rtl) {
			$ox = $this->w - $x - $mc_margin['R'];
		} else {
			$ox = $x + $mc_margin['L'];
		}
		$this->x = $ox;
		$this->y = $oy;
		// set width
		if ($this->empty_string($w) OR ($w <= 0)) {
			if ($this->rtl) {
				$w = $this->x - $this->lMargin - $mc_margin['L'];
			} else {
				$w = $this->w - $this->x - $this->rMargin - $mc_margin['R'];
			}
		}
		// store original margin values
		$lMargin = $this->lMargin;
		$rMargin = $this->rMargin;
		if ($this->rtl) {
			$this->rMargin = $this->w - $this->x;
			$this->lMargin = $this->x - $w;
		} else {
			$this->lMargin = $this->x;
			$this->rMargin = $this->w - $this->x - $w;
		}
		if ($autopadding) {
			// add top padding
			$this->y += $mc_padding['T'];
		}
		if ($ishtml) { // ******* Write HTML text
			$this->writeHTML($txt, true, false, $reseth, true, $align);
			$nl = 1;
		} else { // ******* Write simple text
			$prev_FontSizePt = $this->FontSizePt;
			// vertical alignment
			if ($maxh > 0) {
				// get text height
				$text_height = $this->getStringHeight($w, $txt, $reseth, $autopadding, $mc_padding, $border);
				if ($fitcell) {
					// try to reduce font size to fit text on cell (use a quick search algorithm)
					$fmin = 1;
					$fmax = $this->FontSizePt;
					$prev_text_height = $text_height;
					$maxit = 100; // max number of iterations
					while ($maxit > 0) {
						$fmid = (($fmax + $fmin) / 2);
						$this->SetFontSize($fmid, false);
						$this->resetLastH();
						$text_height = $this->getStringHeight($w, $txt, $reseth, $autopadding, $mc_padding, $border);
						if (($text_height == $maxh) OR (($text_height < $maxh) AND ($fmin >= ($fmax - 0.01)))) {
							break;
						} elseif ($text_height < $maxh) {
							$fmin = $fmid;
						} else {
							$fmax = $fmid;
						}
						--$maxit;
					}
					$this->SetFontSize($this->FontSizePt);
				}
				if ($text_height < $maxh) {
					if ($valign == 'M') {
						// text vertically centered
						$this->y += (($maxh - $text_height) / 2);
					} elseif ($valign == 'B') {
						// text vertically aligned on bottom
						$this->y += ($maxh - $text_height);
					}
				}
			}
			$nl = $this->Write($this->lasth, $txt, '', 0, $align, true, $stretch, false, true, $maxh, 0, $mc_margin);
			if ($fitcell) {
				// restore font size
				$this->SetFontSize($prev_FontSizePt);
			}
		}
		if ($autopadding) {
			// add bottom padding
			$this->y += $mc_padding['B'];
		}
		// Get end-of-text Y position
		$currentY = $this->y;
		// get latest page number
		$endpage = $this->page;
		if ($resth > 0) {
			$skip = ($endpage - $startpage);
			$tmpresth = $resth;
			while ($tmpresth > 0) {
				if ($skip <= 0) {
					// add a page (or trig AcceptPageBreak() for multicolumn mode)
					$this->checkPageBreak($this->PageBreakTrigger + 1);
				}
				if ($this->num_columns > 1) {
					$tmpresth -= ($this->h - $this->y - $this->bMargin);
				} else {
					$tmpresth -= ($this->h - $this->tMargin - $this->bMargin);
				}
				--$skip;
			}
			$currentY = $this->y;
			$endpage = $this->page;
		}
		// get latest column
		$endcolumn = $this->current_column;
		if ($this->num_columns == 0) {
			$this->num_columns = 1;
		}
		// get border modes
		$border_start = $this->getBorderMode($border, $position='start');
		$border_end = $this->getBorderMode($border, $position='end');
		$border_middle = $this->getBorderMode($border, $position='middle');
		// design borders around HTML cells.
		for ($page = $startpage; $page <= $endpage; ++$page) { // for each page
			$ccode = '';
			$this->setPage($page);
			if ($this->num_columns < 2) {
				// single-column mode
				$this->SetX($x);
				$this->y = $this->tMargin;
			}
			// account for margin changes
			if ($page > $startpage) {
				if (($this->rtl) AND ($this->pagedim[$page]['orm'] != $this->pagedim[$startpage]['orm'])) {
					$this->x -= ($this->pagedim[$page]['orm'] - $this->pagedim[$startpage]['orm']);
				} elseif ((!$this->rtl) AND ($this->pagedim[$page]['olm'] != $this->pagedim[$startpage]['olm'])) {
					$this->x += ($this->pagedim[$page]['olm'] - $this->pagedim[$startpage]['olm']);
				}
			}
			if ($startpage == $endpage) {
				// single page
				for ($column = $startcolumn; $column <= $endcolumn; ++$column) { // for each column
					$this->selectColumn($column);
					if ($this->rtl) {
						$this->x -= $mc_margin['R'];
					} else {
						$this->x += $mc_margin['L'];
					}
					if ($startcolumn == $endcolumn) { // single column
						$cborder = $border;
						$h = max($h, ($currentY - $oy));
						$this->y = $oy;
					} elseif ($column == $startcolumn) { // first column
						$cborder = $border_start;
						$this->y = $oy;
						$h = $this->h - $this->y - $this->bMargin;
					} elseif ($column == $endcolumn) { // end column
						$cborder = $border_end;
						$h = $currentY - $this->y;
						if ($resth > $h) {
							$h = $resth;
						}
					} else { // middle column
						$cborder = $border_middle;
						$h = $this->h - $this->y - $this->bMargin;
						$resth -= $h;
					}
					$ccode .= $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, true)."\n";
				} // end for each column
			} elseif ($page == $startpage) { // first page
				for ($column = $startcolumn; $column < $this->num_columns; ++$column) { // for each column
					$this->selectColumn($column);
					if ($this->rtl) {
						$this->x -= $mc_margin['R'];
					} else {
						$this->x += $mc_margin['L'];
					}
					if ($column == $startcolumn) { // first column
						$cborder = $border_start;
						$this->y = $oy;
						$h = $this->h - $this->y - $this->bMargin;
					} else { // middle column
						$cborder = $border_middle;
						$h = $this->h - $this->y - $this->bMargin;
						$resth -= $h;
					}
					$ccode .= $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, true)."\n";
				} // end for each column
			} elseif ($page == $endpage) { // last page
				for ($column = 0; $column <= $endcolumn; ++$column) { // for each column
					$this->selectColumn($column);
					if ($this->rtl) {
						$this->x -= $mc_margin['R'];
					} else {
						$this->x += $mc_margin['L'];
					}
					if ($column == $endcolumn) {
						// end column
						$cborder = $border_end;
						$h = $currentY - $this->y;
						if ($resth > $h) {
							$h = $resth;
						}
					} else {
						// middle column
						$cborder = $border_middle;
						$h = $this->h - $this->y - $this->bMargin;
						$resth -= $h;
					}
					$ccode .= $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, true)."\n";
				} // end for each column
			} else { // middle page
				for ($column = 0; $column < $this->num_columns; ++$column) { // for each column
					$this->selectColumn($column);
					if ($this->rtl) {
						$this->x -= $mc_margin['R'];
					} else {
						$this->x += $mc_margin['L'];
					}
					$cborder = $border_middle;
					$h = $this->h - $this->y - $this->bMargin;
					$resth -= $h;
					$ccode .= $this->getCellCode($w, $h, '', $cborder, 1, '', $fill, '', 0, true)."\n";
				} // end for each column
			}
			if ($cborder OR $fill) {
				$offsetlen = strlen($ccode);
				// draw border and fill
				if ($this->inxobj) {
					// we are inside an XObject template
					if (end($this->xobjects[$this->xobjid]['transfmrk']) !== false) {
						$pagemarkkey = key($this->xobjects[$this->xobjid]['transfmrk']);
						$pagemark = $this->xobjects[$this->xobjid]['transfmrk'][$pagemarkkey];
						$this->xobjects[$this->xobjid]['transfmrk'][$pagemarkkey] += $offsetlen;
					} else {
						$pagemark = $this->xobjects[$this->xobjid]['intmrk'];
						$this->xobjects[$this->xobjid]['intmrk'] += $offsetlen;
					}
					$pagebuff = $this->xobjects[$this->xobjid]['outdata'];
					$pstart = substr($pagebuff, 0, $pagemark);
					$pend = substr($pagebuff, $pagemark);
					$this->xobjects[$this->xobjid]['outdata'] = $pstart.$ccode.$pend;
				} else {
					if (end($this->transfmrk[$this->page]) !== false) {
						$pagemarkkey = key($this->transfmrk[$this->page]);
						$pagemark = $this->transfmrk[$this->page][$pagemarkkey];
						$this->transfmrk[$this->page][$pagemarkkey] += $offsetlen;
					} elseif ($this->InFooter) {
						$pagemark = $this->footerpos[$this->page];
						$this->footerpos[$this->page] += $offsetlen;
					} else {
						$pagemark = $this->intmrk[$this->page];
						$this->intmrk[$this->page] += $offsetlen;
					}
					$pagebuff = $this->getPageBuffer($this->page);
					$pstart = substr($pagebuff, 0, $pagemark);
					$pend = substr($pagebuff, $pagemark);
					$this->setPageBuffer($this->page, $pstart.$ccode.$pend);
				}
			}
		} // end for each page
		// Get end-of-cell Y position
		$currentY = $this->GetY();
		// restore previous values
		if ($this->num_columns > 1) {
			$this->selectColumn();
		} else {
			// restore original margins
			$this->lMargin = $lMargin;
			$this->rMargin = $rMargin;
			if ($this->page > $startpage) {
				// check for margin variations between pages (i.e. booklet mode)
				$dl = ($this->pagedim[$this->page]['olm'] - $this->pagedim[$startpage]['olm']);
				$dr = ($this->pagedim[$this->page]['orm'] - $this->pagedim[$startpage]['orm']);
				if (($dl != 0) OR ($dr != 0)) {
					$this->lMargin += $dl;
					$this->rMargin += $dr;
				}
			}
		}
		if ($ln > 0) {
			//Go to the beginning of the next line
			$this->SetY($currentY + $mc_margin['B']);
			if ($ln == 2) {
				$this->SetX($x + $w + $mc_margin['L'] + $mc_margin['R']);
			}
		} else {
			// go left or right by case
			$this->setPage($startpage);
			$this->y = $y;
			$this->SetX($x + $w + $mc_margin['L'] + $mc_margin['R']);
		}
		$this->setContentMark();
		$this->cell_padding = $prev_cell_padding;
		$this->cell_margin = $prev_cell_margin;
		return $nl;
	}

	/**
	 * Get the border mode accounting for multicell position (opens bottom side of multicell crossing pages)
	 * @param $brd (mixed) Indicates if borders must be drawn around the cell block. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul>or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $position (string) multicell position: 'start', 'middle', 'end'
	 * @return border mode array
	 * @protected
	 * @since 4.4.002 (2008-12-09)
	 */
	protected function getBorderMode($brd, $position='start') {
		if ((!$this->opencell) OR empty($brd)) {
			return $brd;
		}
		if ($brd == 1) {
			$brd = 'LTRB';
		}
		if (is_string($brd)) {
			// convert string to array
			$slen = strlen($brd);
			$newbrd = array();
			for ($i = 0; $i < $slen; ++$i) {
				$newbrd[$brd[$i]] = array('cap' => 'square', 'join' => 'miter');
			}
			$brd = $newbrd;
		}
		foreach ($brd as $border => $style) {
			switch ($position) {
				case 'start': {
					if (strpos($border, 'B') !== false) {
						// remove bottom line
						$newkey = str_replace('B', '', $border);
						if (strlen($newkey) > 0) {
							$brd[$newkey] = $style;
						}
						unset($brd[$border]);
					}
					break;
				}
				case 'middle': {
					if (strpos($border, 'B') !== false) {
						// remove bottom line
						$newkey = str_replace('B', '', $border);
						if (strlen($newkey) > 0) {
							$brd[$newkey] = $style;
						}
						unset($brd[$border]);
						$border = $newkey;
					}
					if (strpos($border, 'T') !== false) {
						// remove bottom line
						$newkey = str_replace('T', '', $border);
						if (strlen($newkey) > 0) {
							$brd[$newkey] = $style;
						}
						unset($brd[$border]);
					}
					break;
				}
				case 'end': {
					if (strpos($border, 'T') !== false) {
						// remove bottom line
						$newkey = str_replace('T', '', $border);
						if (strlen($newkey) > 0) {
							$brd[$newkey] = $style;
						}
						unset($brd[$border]);
					}
					break;
				}
			}
		}
		return $brd;
	}

	/**
	 * This method return the estimated number of lines for print a simple text string using Multicell() method.
	 * @param $txt (string) String for calculating his height
	 * @param $w (float) Width of cells. If 0, they extend up to the right margin of the page.
	 * @param $reseth (boolean) if true reset the last cell height (default false).
	 * @param $autopadding (boolean) if true, uses internal padding and automatically adjust it to account for line width (default true).
	 * @param $cellpadding (float) Internal cell padding, if empty uses default cell padding.
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @return float Return the minimal height needed for multicell method for printing the $txt param.
	 * @author Alexander Escalona Fern?ndez, Nicola Asuni
	 * @public
	 * @since 4.5.011
	 */
	public function getNumLines($txt, $w=0, $reseth=false, $autopadding=true, $cellpadding='', $border=0) {
		if ($txt === '') {
			// empty string
			return 1;
		}
		// adjust internal padding
		$prev_cell_padding = $this->cell_padding;
		$prev_lasth = $this->lasth;
		if (is_array($cellpadding)) {
			$this->cell_padding = $cellpadding;
		}
		$this->adjustCellPadding($border);
		if ($this->empty_string($w) OR ($w <= 0)) {
			if ($this->rtl) {
				$w = $this->x - $this->lMargin;
			} else {
				$w = $this->w - $this->rMargin - $this->x;
			}
		}
		$wmax = $w - $this->cell_padding['L'] - $this->cell_padding['R'];
		if ($reseth) {
			// reset row height
			$this->resetLastH();
		}
		$lines = 1;
		$sum = 0;
		$chars = $this->utf8Bidi($this->UTF8StringToArray($txt), $txt, $this->tmprtl);
		$charsWidth = $this->GetArrStringWidth($chars, '', '', 0, true);
		$length = count($chars);
		$lastSeparator = -1;
		for ($i = 0; $i < $length; ++$i) {
			$charWidth = $charsWidth[$i];
			if (preg_match($this->re_spaces, $this->unichr($chars[$i]))) {
				$lastSeparator = $i;
			}
			if ((($sum + $charWidth) > $wmax) OR ($chars[$i] == 10)) {
				++$lines;
				if ($chars[$i] == 10) {
					$lastSeparator = -1;
					$sum = 0;
				} elseif ($lastSeparator != -1) {
					$i = $lastSeparator;
					$lastSeparator = -1;
					$sum = 0;
				} else {
					$sum = $charWidth;
				}
			} else {
				$sum += $charWidth;
			}
		}
		if ($chars[($length - 1)] == 10) {
			--$lines;
		}
		$this->cell_padding = $prev_cell_padding;
		$this->lasth = $prev_lasth;
		return $lines;
	}

	/**
	 * This method return the estimated height needed for printing a simple text string using the Multicell() method.
	 * Generally, if you want to know the exact height for a block of content you can use the following alternative technique:
	 * @pre
	 *  // store current object
	 *  $pdf->startTransaction();
	 *  // store starting values
	 *  $start_y = $pdf->GetY();
	 *  $start_page = $pdf->getPage();
	 *  // call your printing functions with your parameters
	 *  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 *  $pdf->MultiCell($w=0, $h=0, $txt, $border=1, $align='L', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0);
	 *  // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	 *  // get the new Y
	 *  $end_y = $pdf->GetY();
	 *  $end_page = $pdf->getPage();
	 *  // calculate height
	 *  $height = 0;
	 *  if ($end_page == $start_page) {
	 *  	$height = $end_y - $start_y;
	 *  } else {
	 *  	for ($page=$start_page; $page <= $end_page; ++$page) {
	 *  		$this->setPage($page);
	 *  		if ($page == $start_page) {
	 *  			// first page
	 *  			$height = $this->h - $start_y - $this->bMargin;
	 *  		} elseif ($page == $end_page) {
	 *  			// last page
	 *  			$height = $end_y - $this->tMargin;
	 *  		} else {
	 *  			$height = $this->h - $this->tMargin - $this->bMargin;
	 *  		}
	 *  	}
	 *  }
	 *  // restore previous object
	 *  $pdf = $pdf->rollbackTransaction();
	 *
	 * @param $w (float) Width of cells. If 0, they extend up to the right margin of the page.
	 * @param $txt (string) String for calculating his height
	 * @param $reseth (boolean) if true reset the last cell height (default false).
	 * @param $autopadding (boolean) if true, uses internal padding and automatically adjust it to account for line width (default true).
	 * @param $cellpadding (float) Internal cell padding, if empty uses default cell padding.
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @return float Return the minimal height needed for multicell method for printing the $txt param.
	 * @author Nicola Asuni, Alexander Escalona Fern?ndez
	 * @public
	 */
	public function getStringHeight($w, $txt, $reseth=false, $autopadding=true, $cellpadding='', $border=0) {
		// adjust internal padding
		$prev_cell_padding = $this->cell_padding;
		$prev_lasth = $this->lasth;
		if (is_array($cellpadding)) {
			$this->cell_padding = $cellpadding;
		}
		$this->adjustCellPadding($border);
		$lines = $this->getNumLines($txt, $w, $reseth, $autopadding, $cellpadding, $border);
		$height = $lines * ($this->FontSize * $this->cell_height_ratio);
		if ($autopadding) {
			// add top and bottom padding
			$height += ($this->cell_padding['T'] + $this->cell_padding['B']);
		}
		$this->cell_padding = $prev_cell_padding;
		$this->lasth = $prev_lasth;
		return $height;
	}

	/**
	 * This method prints text from the current position.<br />
	 * @param $h (float) Line height
	 * @param $txt (string) String to print
	 * @param $link (mixed) URL or identifier returned by AddLink()
	 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
	 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
	 * @param $ln (boolean) if true set cursor at the bottom of the line, otherwise set cursor at the top of the line.
	 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
	 * @param $firstline (boolean) if true prints only the first line and return the remaining string.
	 * @param $firstblock (boolean) if true the string is the starting of a line.
	 * @param $maxh (float) maximum height. The remaining unprinted text will be returned. It should be >= $h and less then remaining space to the bottom of the page, or 0 for disable this feature.
	 * @param $wadj (float) first line width will be reduced by this amount (used in HTML mode).
	 * @param $margin (array) margin array of the parent container
	 * @return mixed Return the number of cells or the remaining string if $firstline = true.
	 * @public
	 * @since 1.5
	 */
	public function Write($h, $txt, $link='', $fill=false, $align='', $ln=false, $stretch=0, $firstline=false, $firstblock=false, $maxh=0, $wadj=0, $margin='') {
		// check page for no-write regions and adapt page margins if necessary
		list($this->x, $this->y) = $this->checkPageRegions($h, $this->x, $this->y);
		if (strlen($txt) == 0) {
			// fix empty text
			$txt = ' ';
		}
		if ($margin === '') {
			// set default margins
			$margin = $this->cell_margin;
		}
		// remove carriage returns
		$s = str_replace("\r", '', $txt);
		// check if string contains arabic text
		if (preg_match($this->unicode->uni_RE_PATTERN_ARABIC, $s)) {
			$arabic = true;
		} else {
			$arabic = false;
		}
		// check if string contains RTL text
		if ($arabic OR ($this->tmprtl == 'R') OR preg_match($this->unicode->uni_RE_PATTERN_RTL, $s)) {
			$rtlmode = true;
		} else {
			$rtlmode = false;
		}
		// get a char width
		$chrwidth = $this->GetCharWidth(46); // dot character
		// get array of unicode values
		$chars = $this->UTF8StringToArray($s);
		// get array of chars
		$uchars = $this->UTF8ArrayToUniArray($chars);
		// get the number of characters
		$nb = count($chars);
		// replacement for SHY character (minus symbol)
		$shy_replacement = 45;
		$shy_replacement_char = $this->unichr($shy_replacement);
		// widht for SHY replacement
		$shy_replacement_width = $this->GetCharWidth($shy_replacement);
		// max Y
		$maxy = $this->y + $maxh - $h - $this->cell_padding['T'] - $this->cell_padding['B'];
		// page width
		$pw = $w = $this->w - $this->lMargin - $this->rMargin;
		// calculate remaining line width ($w)
		if ($this->rtl) {
			$w = $this->x - $this->lMargin;
		} else {
			$w = $this->w - $this->rMargin - $this->x;
		}
		// max column width
		$wmax = $w - $wadj;
		if (!$firstline) {
			$wmax -= ($this->cell_padding['L'] + $this->cell_padding['R']);
		}
		if ((!$firstline) AND (($chrwidth > $wmax) OR ($this->GetCharWidth($chars[0]) > $wmax))) {
			// a single character do not fit on column
			return '';
		}
		// minimum row height
		$row_height = max($h, $this->FontSize * $this->cell_height_ratio);
		$start_page = $this->page;
		$i = 0; // character position
		$j = 0; // current starting position
		$sep = -1; // position of the last blank space
		$shy = false; // true if the last blank is a soft hypen (SHY)
		$l = 0; // current string length
		$nl = 0; //number of lines
		$linebreak = false;
		$pc = 0; // previous character
		// for each character
		while ($i < $nb) {
			if (($maxh > 0) AND ($this->y >= $maxy) ) {
				break;
			}
			//Get the current character
			$c = $chars[$i];
			if ($c == 10) { // 10 = "\n" = new line
				//Explicit line break
				if ($align == 'J') {
					if ($this->rtl) {
						$talign = 'R';
					} else {
						$talign = 'L';
					}
				} else {
					$talign = $align;
				}
				$tmpstr = $this->UniArrSubString($uchars, $j, $i);
				if ($firstline) {
					$startx = $this->x;
					$tmparr = array_slice($chars, $j, ($i - $j));
					if ($rtlmode) {
						$tmparr = $this->utf8Bidi($tmparr, $tmpstr, $this->tmprtl);
					}
					$linew = $this->GetArrStringWidth($tmparr);
					unset($tmparr);
					if ($this->rtl) {
						$this->endlinex = $startx - $linew;
					} else {
						$this->endlinex = $startx + $linew;
					}
					$w = $linew;
					$tmpcellpadding = $this->cell_padding;
					if ($maxh == 0) {
						$this->SetCellPadding(0);
					}
				}
				if ($firstblock AND $this->isRTLTextDir()) {
					$tmpstr = $this->stringRightTrim($tmpstr);
				}
				// Skip newlines at the begining of a page or column
				if (!empty($tmpstr) OR ($this->y < ($this->PageBreakTrigger - $row_height))) {
					$this->Cell($w, $h, $tmpstr, 0, 1, $talign, $fill, $link, $stretch);
				}
				unset($tmpstr);
				if ($firstline) {
					$this->cell_padding = $tmpcellpadding;
					return ($this->UniArrSubString($uchars, $i));
				}
				++$nl;
				$j = $i + 1;
				$l = 0;
				$sep = -1;
				$shy = false;
				// account for margin changes
				if ((($this->y + $this->lasth) > $this->PageBreakTrigger) AND ($this->inPageBody())) {
					$this->AcceptPageBreak();
					if ($this->rtl) {
						$this->x -= $margin['R'];
					} else {
						$this->x += $margin['L'];
					}
					$this->lMargin += $margin['L'];
					$this->rMargin += $margin['R'];
				}
				$w = $this->getRemainingWidth();
				$wmax = $w - $this->cell_padding['L'] - $this->cell_padding['R'];
			} else {
				// 160 is the non-breaking space.
				// 173 is SHY (Soft Hypen).
				// \p{Z} or \p{Separator}: any kind of Unicode whitespace or invisible separator.
				// \p{Lo} or \p{Other_Letter}: a Unicode letter or ideograph that does not have lowercase and uppercase variants.
				// \p{Lo} is needed because Chinese characters are packed next to each other without spaces in between.
				if (($c != 160) AND (($c == 173) OR preg_match($this->re_spaces, $this->unichr($c)))) {
					// update last blank space position
					$sep = $i;
					// check if is a SHY
					if ($c == 173) {
						$shy = true;
						if ($pc == 45) {
							$tmp_shy_replacement_width = 0;
							$tmp_shy_replacement_char = '';
						} else {
							$tmp_shy_replacement_width = $shy_replacement_width;
							$tmp_shy_replacement_char = $shy_replacement_char;
						}
					} else {
						$shy = false;
					}
				}
				// update string length
				if ($this->isUnicodeFont() AND ($arabic)) {
					// with bidirectional algorithm some chars may be changed affecting the line length
					// *** very slow ***
					$l = $this->GetArrStringWidth($this->utf8Bidi(array_slice($chars, $j, ($i - $j)), '', $this->tmprtl));
				} else {
					$l += $this->GetCharWidth($c);
				}
				if (($l > $wmax) OR (($c == 173) AND (($l + $tmp_shy_replacement_width) > $wmax)) ) {
					// we have reached the end of column
					if ($sep == -1) {
						// check if the line was already started
						if (($this->rtl AND ($this->x <= ($this->w - $this->rMargin - $chrwidth)))
							OR ((!$this->rtl) AND ($this->x >= ($this->lMargin + $chrwidth)))) {
							// print a void cell and go to next line
							$this->Cell($w, $h, '', 0, 1);
							$linebreak = true;
							if ($firstline) {
								return ($this->UniArrSubString($uchars, $j));
							}
						} else {
							// truncate the word because do not fit on column
							$tmpstr = $this->UniArrSubString($uchars, $j, $i);
							if ($firstline) {
								$startx = $this->x;
								$tmparr = array_slice($chars, $j, ($i - $j));
								if ($rtlmode) {
									$tmparr = $this->utf8Bidi($tmparr, $tmpstr, $this->tmprtl);
								}
								$linew = $this->GetArrStringWidth($tmparr);
								unset($tmparr);
								if ($this->rtl) {
									$this->endlinex = $startx - $linew;
								} else {
									$this->endlinex = $startx + $linew;
								}
								$w = $linew;
								$tmpcellpadding = $this->cell_padding;
								if ($maxh == 0) {
									$this->SetCellPadding(0);
								}
							}
							if ($firstblock AND $this->isRTLTextDir()) {
								$tmpstr = $this->stringRightTrim($tmpstr);
							}
							$this->Cell($w, $h, $tmpstr, 0, 1, $align, $fill, $link, $stretch);
							unset($tmpstr);
							if ($firstline) {
								$this->cell_padding = $tmpcellpadding;
								return ($this->UniArrSubString($uchars, $i));
							}
							$j = $i;
							--$i;
						}
					} else {
						// word wrapping
						if ($this->rtl AND (!$firstblock) AND ($sep < $i)) {
							$endspace = 1;
						} else {
							$endspace = 0;
						}
						// check the length of the next string
						$strrest = $this->UniArrSubString($uchars, ($sep + $endspace));
						$nextstr = preg_split('/'.$this->re_space['p'].'/'.$this->re_space['m'], $this->stringTrim($strrest));
						if (isset($nextstr[0]) AND ($this->GetStringWidth($nextstr[0]) > $pw)) {
							// truncate the word because do not fit on a full page width
							$tmpstr = $this->UniArrSubString($uchars, $j, $i);
							if ($firstline) {
								$startx = $this->x;
								$tmparr = array_slice($chars, $j, ($i - $j));
								if ($rtlmode) {
									$tmparr = $this->utf8Bidi($tmparr, $tmpstr, $this->tmprtl);
								}
								$linew = $this->GetArrStringWidth($tmparr);
								unset($tmparr);
								if ($this->rtl) {
									$this->endlinex = $startx - $linew;
								} else {
									$this->endlinex = $startx + $linew;
								}
								$w = $linew;
								$tmpcellpadding = $this->cell_padding;
								if ($maxh == 0) {
									$this->SetCellPadding(0);
								}
							}
							if ($firstblock AND $this->isRTLTextDir()) {
								$tmpstr = $this->stringRightTrim($tmpstr);
							}
							$this->Cell($w, $h, $tmpstr, 0, 1, $align, $fill, $link, $stretch);
							unset($tmpstr);
							if ($firstline) {
								$this->cell_padding = $tmpcellpadding;
								return ($this->UniArrSubString($uchars, $i));
							}
							$j = $i;
							--$i;
						} else {
							// word wrapping
							if ($shy) {
								// add hypen (minus symbol) at the end of the line
								$shy_width = $tmp_shy_replacement_width;
								if ($this->rtl) {
									$shy_char_left = $tmp_shy_replacement_char;
									$shy_char_right = '';
								} else {
									$shy_char_left = '';
									$shy_char_right = $tmp_shy_replacement_char;
								}
							} else {
								$shy_width = 0;
								$shy_char_left = '';
								$shy_char_right = '';
							}
							$tmpstr = $this->UniArrSubString($uchars, $j, ($sep + $endspace));
							if ($firstline) {
								$startx = $this->x;
								$tmparr = array_slice($chars, $j, (($sep + $endspace) - $j));
								if ($rtlmode) {
									$tmparr = $this->utf8Bidi($tmparr, $tmpstr, $this->tmprtl);
								}
								$linew = $this->GetArrStringWidth($tmparr);
								unset($tmparr);
								if ($this->rtl) {
									$this->endlinex = $startx - $linew - $shy_width;
								} else {
									$this->endlinex = $startx + $linew + $shy_width;
								}
								$w = $linew;
								$tmpcellpadding = $this->cell_padding;
								if ($maxh == 0) {
									$this->SetCellPadding(0);
								}
							}
							// print the line
							if ($firstblock AND $this->isRTLTextDir()) {
								$tmpstr = $this->stringRightTrim($tmpstr);
							}
							$this->Cell($w, $h, $shy_char_left.$tmpstr.$shy_char_right, 0, 1, $align, $fill, $link, $stretch);
							unset($tmpstr);
							if ($firstline) {
								// return the remaining text
								$this->cell_padding = $tmpcellpadding;
								return ($this->UniArrSubString($uchars, ($sep + $endspace)));
							}
							$i = $sep;
							$sep = -1;
							$shy = false;
							$j = ($i+1);
						}
					}
					// account for margin changes
					if ((($this->y + $this->lasth) > $this->PageBreakTrigger) AND ($this->inPageBody())) {
						$this->AcceptPageBreak();
						if ($this->rtl) {
							$this->x -= $margin['R'];
						} else {
							$this->x += $margin['L'];
						}
						$this->lMargin += $margin['L'];
						$this->rMargin += $margin['R'];
					}
					$w = $this->getRemainingWidth();
					$wmax = $w - $this->cell_padding['L'] - $this->cell_padding['R'];
					if ($linebreak) {
						$linebreak = false;
					} else {
						++$nl;
						$l = 0;
					}
				}
			}
			// save last character
			$pc = $c;
			++$i;
		} // end while i < nb
		// print last substring (if any)
		if ($l > 0) {
			switch ($align) {
				case 'J':
				case 'C': {
					$w = $w;
					break;
				}
				case 'L': {
					if ($this->rtl) {
						$w = $w;
					} else {
						$w = $l;
					}
					break;
				}
				case 'R': {
					if ($this->rtl) {
						$w = $l;
					} else {
						$w = $w;
					}
					break;
				}
				default: {
					$w = $l;
					break;
				}
			}
			$tmpstr = $this->UniArrSubString($uchars, $j, $nb);
			if ($firstline) {
				$startx = $this->x;
				$tmparr = array_slice($chars, $j, ($nb - $j));
				if ($rtlmode) {
					$tmparr = $this->utf8Bidi($tmparr, $tmpstr, $this->tmprtl);
				}
				$linew = $this->GetArrStringWidth($tmparr);
				unset($tmparr);
				if ($this->rtl) {
					$this->endlinex = $startx - $linew;
				} else {
					$this->endlinex = $startx + $linew;
				}
				$w = $linew;
				$tmpcellpadding = $this->cell_padding;
				if ($maxh == 0) {
					$this->SetCellPadding(0);
				}
			}
			if ($firstblock AND $this->isRTLTextDir()) {
				$tmpstr = $this->stringRightTrim($tmpstr);
			}
			$this->Cell($w, $h, $tmpstr, 0, $ln, $align, $fill, $link, $stretch);
			unset($tmpstr);
			if ($firstline) {
				$this->cell_padding = $tmpcellpadding;
				return ($this->UniArrSubString($uchars, $nb));
			}
			++$nl;
		}
		if ($firstline) {
			return '';
		}
		return $nl;
	}

	/**
	 * Returns the remaining width between the current position and margins.
	 * @return int Return the remaining width
	 * @protected
	 */
	protected function getRemainingWidth() {
		list($this->x, $this->y) = $this->checkPageRegions(0, $this->x, $this->y);
		if ($this->rtl) {
			return ($this->x - $this->lMargin);
		} else {
			return ($this->w - $this->rMargin - $this->x);
		}
	}

	/**
	 * Extract a slice of the $strarr array and return it as string.
	 * @param $strarr (string) The input array of characters.
	 * @param $start (int) the starting element of $strarr.
	 * @param $end (int) first element that will not be returned.
	 * @return Return part of a string
	 * @public
	 */
	public function UTF8ArrSubString($strarr, $start='', $end='') {
		if (strlen($start) == 0) {
			$start = 0;
		}
		if (strlen($end) == 0) {
			$end = count($strarr);
		}
		$string = '';
		for ($i=$start; $i < $end; ++$i) {
			$string .= $this->unichr($strarr[$i]);
		}
		return $string;
	}

	/**
	 * Extract a slice of the $uniarr array and return it as string.
	 * @param $uniarr (string) The input array of characters.
	 * @param $start (int) the starting element of $strarr.
	 * @param $end (int) first element that will not be returned.
	 * @return Return part of a string
	 * @public
	 * @since 4.5.037 (2009-04-07)
	 */
	public function UniArrSubString($uniarr, $start='', $end='') {
		if (strlen($start) == 0) {
			$start = 0;
		}
		if (strlen($end) == 0) {
			$end = count($uniarr);
		}
		$string = '';
		for ($i=$start; $i < $end; ++$i) {
			$string .= $uniarr[$i];
		}
		return $string;
	}

	/**
	 * Convert an array of UTF8 values to array of unicode characters
	 * @param $ta (string) The input array of UTF8 values.
	 * @return Return array of unicode characters
	 * @public
	 * @since 4.5.037 (2009-04-07)
	 */
	public function UTF8ArrayToUniArray($ta) {
		return array_map(array($this, 'unichr'), $ta);
	}

	/**
	 * Returns the unicode caracter specified by UTF-8 value
	 * @param $c (int) UTF-8 value
	 * @return Returns the specified character.
	 * @author Miguel Perez, Nicola Asuni
	 * @public
	 * @since 2.3.000 (2008-03-05)
	 */
	public function unichr($c) {
		if (!$this->isunicode) {
			return chr($c);
		} elseif ($c <= 0x7F) {
			// one byte
			return chr($c);
		} elseif ($c <= 0x7FF) {
			// two bytes
			return chr(0xC0 | $c >> 6).chr(0x80 | $c & 0x3F);
		} elseif ($c <= 0xFFFF) {
			// three bytes
			return chr(0xE0 | $c >> 12).chr(0x80 | $c >> 6 & 0x3F).chr(0x80 | $c & 0x3F);
		} elseif ($c <= 0x10FFFF) {
			// four bytes
			return chr(0xF0 | $c >> 18).chr(0x80 | $c >> 12 & 0x3F).chr(0x80 | $c >> 6 & 0x3F).chr(0x80 | $c & 0x3F);
		} else {
			return '';
		}
	}

	/**
	 * Return the image type given the file name or array returned by getimagesize() function.
	 * @param $imgfile (string) image file name
	 * @param $iminfo (array) array of image information returned by getimagesize() function.
	 * @return string image type
	 * @since 4.8.017 (2009-11-27)
	 */
	public function getImageFileType($imgfile, $iminfo=array()) {
		$type = '';
		if (isset($iminfo['mime']) AND !empty($iminfo['mime'])) {
			$mime = explode('/', $iminfo['mime']);
			if ((count($mime) > 1) AND ($mime[0] == 'image') AND (!empty($mime[1]))) {
				$type = strtolower(trim($mime[1]));
			}
		}
		if (empty($type)) {
			$fileinfo = pathinfo($imgfile);
			if (isset($fileinfo['extension']) AND (!$this->empty_string($fileinfo['extension']))) {
				$type = strtolower(trim($fileinfo['extension']));
			}
		}
		if ($type == 'jpg') {
			$type = 'jpeg';
		}
		return $type;
	}

	/**
	 * Set the block dimensions accounting for page breaks and page/column fitting
	 * @param $w (float) width
	 * @param $h (float) height
	 * @param $x (float) X coordinate
	 * @param $y (float) Y coodiante
	 * @param $fitonpage (boolean) if true the block is resized to not exceed page dimensions.
	 * @return array($w, $h, $x, $y)
	 * @protected
	 * @since 5.5.009 (2010-07-05)
	 */
	protected function fitBlock($w, $h, $x, $y, $fitonpage=false) {
		if ($w <= 0) {
			// set maximum width
			$w = ($this->w - $this->lMargin - $this->rMargin);
		}
		if ($h <= 0) {
			// set maximum height
			$h = ($this->PageBreakTrigger - $this->tMargin);
		}
		// resize the block to be vertically contained on a single page or single column
		if ($fitonpage OR $this->AutoPageBreak) {
			$ratio_wh = ($w / $h);
			if ($h > ($this->PageBreakTrigger - $this->tMargin)) {
				$h = $this->PageBreakTrigger - $this->tMargin;
				$w = ($h * $ratio_wh);
			}
			// resize the block to be horizontally contained on a single page or single column
			if ($fitonpage) {
				$maxw = ($this->w - $this->lMargin - $this->rMargin);
				if ($w > $maxw) {
					$w = $maxw;
					$h = ($w / $ratio_wh);
				}
			}
		}
		// Check whether we need a new page or new column first as this does not fit
		$prev_x = $this->x;
		$prev_y = $this->y;
		if ($this->checkPageBreak($h, $y) OR ($this->y < $prev_y)) {
			$y = $this->y;
			if ($this->rtl) {
				$x += ($prev_x - $this->x);
			} else {
				$x += ($this->x - $prev_x);
			}
			$this->newline = true;
		}
		// resize the block to be contained on the remaining available page or column space
		if ($fitonpage) {
			$ratio_wh = ($w / $h);
			if (($y + $h) > $this->PageBreakTrigger) {
				$h = $this->PageBreakTrigger - $y;
				$w = ($h * $ratio_wh);
			}
			if ((!$this->rtl) AND (($x + $w) > ($this->w - $this->rMargin))) {
				$w = $this->w - $this->rMargin - $x;
				$h = ($w / $ratio_wh);
			} elseif (($this->rtl) AND (($x - $w) < ($this->lMargin))) {
				$w = $x - $this->lMargin;
				$h = ($w / $ratio_wh);
			}
		}
		return array($w, $h, $x, $y);
	}

	/**
	 * Puts an image in the page.
	 * The upper-left corner must be given.
	 * The dimensions can be specified in different ways:<ul>
	 * <li>explicit width and height (expressed in user unit)</li>
	 * <li>one explicit dimension, the other being calculated automatically in order to keep the original proportions</li>
	 * <li>no explicit dimension, in which case the image is put at 72 dpi</li></ul>
	 * Supported formats are JPEG and PNG images whitout GD library and all images supported by GD: GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM;
	 * The format can be specified explicitly or inferred from the file extension.<br />
	 * It is possible to put a link on the image.<br />
	 * Remark: if an image is used several times, only one copy will be embedded in the file.<br />
	 * @param $file (string) Name of the file containing the image or a '@' character followed by the image data string. To link an image without embedding it on the document, set an asterisk character before the URL (i.e.: '*http://www.example.com/image.jpg').
	 * @param $x (float) Abscissa of the upper-left corner (LTR) or upper-right corner (RTL).
	 * @param $y (float) Ordinate of the upper-left corner (LTR) or upper-right corner (RTL).
	 * @param $w (float) Width of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $h (float) Height of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $type (string) Image format. Possible values are (case insensitive): JPEG and PNG (whitout GD library) and all images supported by GD: GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM;. If not specified, the type is inferred from the file extension.
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $align (string) Indicates the alignment of the pointer next to image insertion relative to image height. The value can be:<ul><li>T: top-right for LTR or top-left for RTL</li><li>M: middle-right for LTR or middle-left for RTL</li><li>B: bottom-right for LTR or bottom-left for RTL</li><li>N: next line</li></ul>
	 * @param $resize (mixed) If true resize (reduce) the image to fit $w and $h (requires GD or ImageMagick library); if false do not resize; if 2 force resize in all cases (upscaling and downscaling).
	 * @param $dpi (int) dot-per-inch resolution used on resize
	 * @param $palign (string) Allows to center or align the image on the current line. Possible values are:<ul><li>L : left align</li><li>C : center</li><li>R : right align</li><li>'' : empty string : left for LTR or right for RTL</li></ul>
	 * @param $ismask (boolean) true if this image is a mask, false otherwise
	 * @param $imgmask (mixed) image object returned by this function or false
	 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
	 * @param $fitbox (mixed) If not false scale image dimensions proportionally to fit within the ($w, $h) box. $fitbox can be true or a 2 characters string indicating the image alignment inside the box. The first character indicate the horizontal alignment (L = left, C = center, R = right) the second character indicate the vertical algnment (T = top, M = middle, B = bottom).
	 * @param $hidden (boolean) If true do not display the image.
	 * @param $fitonpage (boolean) If true the image is resized to not exceed page dimensions.
	 * @param $alt (boolean) If true the image will be added as alternative and not directly printed (the ID of the image will be returned).
	 * @param $altimgs (array) Array of alternate images IDs. Each alternative image must be an array with two values: an integer representing the image ID (the value returned by the Image method) and a boolean value to indicate if the image is the default for printing.
	 * @return image information
	 * @public
	 * @since 1.1
	 */
	public function Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()) {
		if ($x === '') {
			$x = $this->x;
		}
		if ($y === '') {
			$y = $this->y;
		}
		// check page for no-write regions and adapt page margins if necessary
		list($x, $y) = $this->checkPageRegions($h, $x, $y);
		$cached_file = false; // true when the file is cached
		$exurl = ''; // external streams
		// check if we are passing an image as file or string
		if ($file[0] === '@') {
			// image from string
			$imgdata = substr($file, 1);
			$file = K_PATH_CACHE.'img_'.md5($imgdata);
			$fp = fopen($file, 'w');
			fwrite($fp, $imgdata);
			fclose($fp);
			unset($imgdata);
			$cached_file = true;
			$imsize = @getimagesize($file);
			if ($imsize === FALSE) {
				unlink($file);
				$cached_file = false;
			}
		} else { // image file
			if ($file{0} === '*') {
				// image as external stream
				$file = substr($file, 1);
				$exurl = $file;
			}
			// check if is local file
			if (!@file_exists($file)) {
				// encode spaces on filename (file is probably an URL)
				$file = str_replace(' ', '%20', $file);
			}
			if (@file_exists($file)) {
				// get image dimensions
				$imsize = @getimagesize($file);
			} else {
				$imsize = false;
			}
			if ($imsize === FALSE) {
				if (function_exists('curl_init')) {
					// try to get remote file data using cURL
					$cs = curl_init(); // curl session
					curl_setopt($cs, CURLOPT_URL, $file);
					curl_setopt($cs, CURLOPT_BINARYTRANSFER, true);
					curl_setopt($cs, CURLOPT_FAILONERROR, true);
					curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($cs, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($cs, CURLOPT_CONNECTTIMEOUT, 5);
					curl_setopt($cs, CURLOPT_TIMEOUT, 30);
					curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($cs, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($cs, CURLOPT_USERAGENT, 'TCPDF');
					$imgdata = curl_exec($cs);
					curl_close($cs);
					if ($imgdata !== FALSE) {
						// copy image to cache
						$file = K_PATH_CACHE.'img_'.md5($imgdata);
						$fp = fopen($file, 'w');
						fwrite($fp, $imgdata);
						fclose($fp);
						unset($imgdata);
						$cached_file = true;
						$imsize = @getimagesize($file);
						if ($imsize === FALSE) {
							unlink($file);
							$cached_file = false;
						}
					}
				} elseif (($w > 0) AND ($h > 0)) {
					// get measures from specified data
					$pw = $this->getHTMLUnitToUnits($w, 0, $this->pdfunit, true) * $this->imgscale * $this->k;
					$ph = $this->getHTMLUnitToUnits($h, 0, $this->pdfunit, true) * $this->imgscale * $this->k;
					$imsize = array($pw, $ph);
				}
			}
		}
		if ($imsize === FALSE) {
			if (substr($file, 0, -34) == K_PATH_CACHE.'msk') { // mask file
				// get measures from specified data
				$pw = $this->getHTMLUnitToUnits($w, 0, $this->pdfunit, true) * $this->imgscale * $this->k;
				$ph = $this->getHTMLUnitToUnits($h, 0, $this->pdfunit, true) * $this->imgscale * $this->k;
				$imsize = array($pw, $ph);
			} else {
				$this->Error('[Image] Unable to get image: '.$file);
			}
		}
		// file hash
		$filehash = md5($file);
		// get original image width and height in pixels
		list($pixw, $pixh) = $imsize;
		// calculate image width and height on document
		if (($w <= 0) AND ($h <= 0)) {
			// convert image size to document unit
			$w = $this->pixelsToUnits($pixw);
			$h = $this->pixelsToUnits($pixh);
		} elseif ($w <= 0) {
			$w = $h * $pixw / $pixh;
		} elseif ($h <= 0) {
			$h = $w * $pixh / $pixw;
		} elseif (($fitbox !== false) AND ($w > 0) AND ($h > 0)) {
			if (strlen($fitbox) !== 2) {
				// set default alignment
				$fitbox = '--';
			}
			// scale image dimensions proportionally to fit within the ($w, $h) box
			if ((($w * $pixh) / ($h * $pixw)) < 1) {
				// store current height
				$oldh = $h;
				// calculate new height
				$h = $w * $pixh / $pixw;
				// height difference
				$hdiff = ($oldh - $h);
				// vertical alignment
				switch (strtoupper($fitbox{1})) {
					case 'T': {
						break;
					}
					case 'M': {
						$y += ($hdiff / 2);
						break;
					}
					case 'B': {
						$y += $hdiff;
						break;
					}
				}
			} else {
				// store current width
				$oldw = $w;
				// calculate new width
				$w = $h * $pixw / $pixh;
				// width difference
				$wdiff = ($oldw - $w);
				// horizontal alignment
				switch (strtoupper($fitbox{0})) {
					case 'L': {
						if ($this->rtl) {
							$x -= $wdiff;
						}
						break;
					}
					case 'C': {
						if ($this->rtl) {
							$x -= ($wdiff / 2);
						} else {
							$x += ($wdiff / 2);
						}
						break;
					}
					case 'R': {
						if (!$this->rtl) {
							$x += $wdiff;
						}
						break;
					}
				}
			}
		}
		// fit the image on available space
		list($w, $h, $x, $y) = $this->fitBlock($w, $h, $x, $y, $fitonpage);
		// calculate new minimum dimensions in pixels
		$neww = round($w * $this->k * $dpi / $this->dpi);
		$newh = round($h * $this->k * $dpi / $this->dpi);
		// check if resize is necessary (resize is used only to reduce the image)
		$newsize = ($neww * $newh);
		$pixsize = ($pixw * $pixh);
		if (intval($resize) == 2) {
			$resize = true;
		} elseif ($newsize >= $pixsize) {
			$resize = false;
		}
		// check if image has been already added on document
		$newimage = true;
		if (in_array($file, $this->imagekeys)) {
			$newimage = false;
			// get existing image data
			$info = $this->getImageBuffer($file);
			if (substr($file, 0, -34) != K_PATH_CACHE.'msk') {
				// check if the newer image is larger
				$oldsize = ($info['w'] * $info['h']);
				if ((($oldsize < $newsize) AND ($resize)) OR (($oldsize < $pixsize) AND (!$resize))) {
					$newimage = true;
				}
			}
		} elseif (substr($file, 0, -34) != K_PATH_CACHE.'msk') {
			// check for cached images with alpha channel
			$tempfile_plain = K_PATH_CACHE.'mskp_'.$filehash;
			$tempfile_alpha = K_PATH_CACHE.'mska_'.$filehash;
			if (in_array($tempfile_plain, $this->imagekeys)) {
				// get existing image data
				$info = $this->getImageBuffer($tempfile_plain);
				// check if the newer image is larger
				$oldsize = ($info['w'] * $info['h']);
				if ((($oldsize < $newsize) AND ($resize)) OR (($oldsize < $pixsize) AND (!$resize))) {
					$newimage = true;
				} else {
					$newimage = false;
					// embed mask image
					$imgmask = $this->Image($tempfile_alpha, $x, $y, $w, $h, 'PNG', '', '', $resize, $dpi, '', true, false);
					// embed image, masked with previously embedded mask
					return $this->Image($tempfile_plain, $x, $y, $w, $h, $type, $link, $align, $resize, $dpi, $palign, false, $imgmask);
				}
			}
		}
		if ($newimage) {
			//First use of image, get info
			$type = strtolower($type);
			if ($type == '') {
				$type = $this->getImageFileType($file, $imsize);
			} elseif ($type == 'jpg') {
				$type = 'jpeg';
			}
			$mqr = $this->get_mqr();
			$this->set_mqr(false);
			// Specific image handlers
			$mtd = '_parse'.$type;
			// GD image handler function
			$gdfunction = 'imagecreatefrom'.$type;
			$info = false;
			if ((method_exists($this, $mtd)) AND (!($resize AND (function_exists($gdfunction) OR extension_loaded('imagick'))))) {
				// TCPDF image functions
				$info = $this->$mtd($file);
				if ($info == 'pngalpha') {
					return $this->ImagePngAlpha($file, $x, $y, $pixw, $pixh, $w, $h, 'PNG', $link, $align, $resize, $dpi, $palign, $filehash);
				}
			}
			if (!$info) {
				if (function_exists($gdfunction)) {
					// GD library
					$img = $gdfunction($file);
					if ($resize) {
						$imgr = imagecreatetruecolor($neww, $newh);
						if (($type == 'gif') OR ($type == 'png')) {
							$imgr = $this->_setGDImageTransparency($imgr, $img);
						}
						imagecopyresampled($imgr, $img, 0, 0, 0, 0, $neww, $newh, $pixw, $pixh);
						if (($type == 'gif') OR ($type == 'png')) {
							$info = $this->_toPNG($imgr);
						} else {
							$info = $this->_toJPEG($imgr);
						}
					} else {
						if (($type == 'gif') OR ($type == 'png')) {
							$info = $this->_toPNG($img);
						} else {
							$info = $this->_toJPEG($img);
						}
					}
				} elseif (extension_loaded('imagick')) {
					// ImageMagick library
					$img = new Imagick();
					if ($type == 'SVG') {
						// get SVG file content
						$svgimg = file_get_contents($file);
						// get width and height
						$regs = array();
						if (preg_match('/<svg([^\>]*)>/si', $svgimg, $regs)) {
							$svgtag = $regs[1];
							$tmp = array();
							if (preg_match('/[\s]+width[\s]*=[\s]*"([^"]*)"/si', $svgtag, $tmp)) {
								$ow = $this->getHTMLUnitToUnits($tmp[1], 1, $this->svgunit, false);
								$owu = sprintf('%F', ($ow * $dpi / 72)).$this->pdfunit;
								$svgtag = preg_replace('/[\s]+width[\s]*=[\s]*"[^"]*"/si', ' width="'.$owu.'"', $svgtag, 1);
							} else {
								$ow = $w;
							}
							$tmp = array();
							if (preg_match('/[\s]+height[\s]*=[\s]*"([^"]*)"/si', $svgtag, $tmp)) {
								$oh = $this->getHTMLUnitToUnits($tmp[1], 1, $this->svgunit, false);
								$ohu = sprintf('%F', ($oh * $dpi / 72)).$this->pdfunit;
								$svgtag = preg_replace('/[\s]+height[\s]*=[\s]*"[^"]*"/si', ' height="'.$ohu.'"', $svgtag, 1);
							} else {
								$oh = $h;
							}
							$tmp = array();
							if (!preg_match('/[\s]+viewBox[\s]*=[\s]*"[\s]*([0-9\.]+)[\s]+([0-9\.]+)[\s]+([0-9\.]+)[\s]+([0-9\.]+)[\s]*"/si', $svgtag, $tmp)) {
								$vbw = ($ow * $this->imgscale * $this->k);
								$vbh = ($oh * $this->imgscale * $this->k);
								$vbox = sprintf(' viewBox="0 0 %F %F" ', $vbw, $vbh);
								$svgtag = $vbox.$svgtag;
							}
							$svgimg = preg_replace('/<svg([^\>]*)>/si', '<svg'.$svgtag.'>', $svgimg, 1);
						}
						$img->readImageBlob($svgimg);
					} else {
						$img->readImage($file);
					}
					if ($resize) {
						$img->resizeImage($neww, $newh, 10, 1, false);
					}
					$img->setCompressionQuality($this->jpeg_quality);
					$img->setImageFormat('jpeg');
					$tempname = tempnam(K_PATH_CACHE, 'jpg_');
					$img->writeImage($tempname);
					$info = $this->_parsejpeg($tempname);
					unlink($tempname);
					$img->destroy();
				} else {
					return;
				}
			}
			if ($info === false) {
				//If false, we cannot process image
				return;
			}
			$this->set_mqr($mqr);
			if ($ismask) {
				// force grayscale
				$info['cs'] = 'DeviceGray';
			}
			$info['i'] = $this->numimages;
			if (!in_array($file, $this->imagekeys)) {
				++$info['i'];
			}
			if ($imgmask !== false) {
				$info['masked'] = $imgmask;
			}
			if (!empty($exurl)) {
				$info['exurl'] = $exurl;
			}
			// array of alternative images
			$info['altimgs'] = $altimgs;
			// add image to document
			$this->setImageBuffer($file, $info);
		}
		if ($cached_file) {
			// remove cached file
			unlink($file);
		}
		// set alignment
		$this->img_rb_y = $y + $h;
		// set alignment
		if ($this->rtl) {
			if ($palign == 'L') {
				$ximg = $this->lMargin;
			} elseif ($palign == 'C') {
				$ximg = ($this->w + $this->lMargin - $this->rMargin - $w) / 2;
			} elseif ($palign == 'R') {
				$ximg = $this->w - $this->rMargin - $w;
			} else {
				$ximg = $x - $w;
			}
			$this->img_rb_x = $ximg;
		} else {
			if ($palign == 'L') {
				$ximg = $this->lMargin;
			} elseif ($palign == 'C') {
				$ximg = ($this->w + $this->lMargin - $this->rMargin - $w) / 2;
			} elseif ($palign == 'R') {
				$ximg = $this->w - $this->rMargin - $w;
			} else {
				$ximg = $x;
			}
			$this->img_rb_x = $ximg + $w;
		}
		if ($ismask OR $hidden) {
			// image is not displayed
			return $info['i'];
		}
		$xkimg = $ximg * $this->k;
		if (!$alt) {
			// only non-alternative immages will be set
			$this->_out(sprintf('q %F 0 0 %F %F %F cm /I%u Do Q', ($w * $this->k), ($h * $this->k), $xkimg, (($this->h - ($y + $h)) * $this->k), $info['i']));
		}
		if (!empty($border)) {
			$bx = $this->x;
			$by = $this->y;
			$this->x = $ximg;
			if ($this->rtl) {
				$this->x += $w;
			}
			$this->y = $y;
			$this->Cell($w, $h, '', $border, 0, '', 0, '', 0, true);
			$this->x = $bx;
			$this->y = $by;
		}
		if ($link) {
			$this->Link($ximg, $y, $w, $h, $link, 0);
		}
		// set pointer to align the next text/objects
		switch($align) {
			case 'T': {
				$this->y = $y;
				$this->x = $this->img_rb_x;
				break;
			}
			case 'M': {
				$this->y = $y + round($h/2);
				$this->x = $this->img_rb_x;
				break;
			}
			case 'B': {
				$this->y = $this->img_rb_y;
				$this->x = $this->img_rb_x;
				break;
			}
			case 'N': {
				$this->SetY($this->img_rb_y);
				break;
			}
			default:{
				break;
			}
		}
		$this->endlinex = $this->img_rb_x;
		if ($this->inxobj) {
			// we are inside an XObject template
			$this->xobjects[$this->xobjid]['images'][] = $info['i'];
		}
		return $info['i'];
	}

	/**
	 * Sets the current active configuration setting of magic_quotes_runtime (if the set_magic_quotes_runtime function exist)
	 * @param $mqr (boolean) FALSE for off, TRUE for on.
	 * @since 4.6.025 (2009-08-17)
	 */
	public function set_mqr($mqr) {
		if (!defined('PHP_VERSION_ID')) {
			$version = PHP_VERSION;
			define('PHP_VERSION_ID', (($version{0} * 10000) + ($version{2} * 100) + $version{4}));
		}
		if (PHP_VERSION_ID < 50300) {
			@set_magic_quotes_runtime($mqr);
		}
	}

	/**
	 * Gets the current active configuration setting of magic_quotes_runtime (if the get_magic_quotes_runtime function exist)
	 * @return Returns 0 if magic quotes runtime is off or get_magic_quotes_runtime doesn't exist, 1 otherwise.
	 * @since 4.6.025 (2009-08-17)
	 */
	public function get_mqr() {
		if (!defined('PHP_VERSION_ID')) {
			$version = PHP_VERSION;
			define('PHP_VERSION_ID', (($version{0} * 10000) + ($version{2} * 100) + $version{4}));
		}
		if (PHP_VERSION_ID < 50300) {
			return @get_magic_quotes_runtime();
		}
		return 0;
	}

	/**
	 * Convert the loaded image to a JPEG and then return a structure for the PDF creator.
	 * This function requires GD library and write access to the directory defined on K_PATH_CACHE constant.
	 * @param $image (image) Image object.
	 * return image JPEG image object.
	 * @protected
	 */
	protected function _toJPEG($image) {
		$tempname = tempnam(K_PATH_CACHE, 'jpg_');
		imagejpeg($image, $tempname, $this->jpeg_quality);
		imagedestroy($image);
		$retvars = $this->_parsejpeg($tempname);
		// tidy up by removing temporary image
		unlink($tempname);
		return $retvars;
	}

	/**
	 * Convert the loaded image to a PNG and then return a structure for the PDF creator.
	 * This function requires GD library and write access to the directory defined on K_PATH_CACHE constant.
	 * @param $image (image) Image object.
	 * return image PNG image object.
	 * @protected
	 * @since 4.9.016 (2010-04-20)
	 */
	protected function _toPNG($image) {
		// set temporary image file name
		$tempname = tempnam(K_PATH_CACHE, 'jpg_');
		// turn off interlaced mode
		imageinterlace($image, 0);
		// create temporary PNG image
		imagepng($image, $tempname);
		// remove image from memory
		imagedestroy($image);
		// get PNG image data
		$retvars = $this->_parsepng($tempname);
		// tidy up by removing temporary image
		unlink($tempname);
		return $retvars;
	}

	/**
	 * Set the transparency for the given GD image.
	 * @param $new_image (image) GD image object
	 * @param $image (image) GD image object.
	 * return GD image object.
	 * @protected
	 * @since 4.9.016 (2010-04-20)
	 */
	protected function _setGDImageTransparency($new_image, $image) {
		// transparency index
		$tid = imagecolortransparent($image);
		// default transparency color
		$tcol = array('red' => 255, 'green' => 255, 'blue' => 255);
		if ($tid >= 0) {
			// get the colors for the transparency index
			$tcol = imagecolorsforindex($image, $tid);
		}
		$tid = imagecolorallocate($new_image, $tcol['red'], $tcol['green'], $tcol['blue']);
		imagefill($new_image, 0, 0, $tid);
		imagecolortransparent($new_image, $tid);
		return $new_image;
	}

	/**
	 * Extract info from a JPEG file without using the GD library.
	 * @param $file (string) image file to parse
	 * @return array structure containing the image data
	 * @protected
	 */
	protected function _parsejpeg($file) {
		$a = getimagesize($file);
		if (empty($a)) {
			$this->Error('Missing or incorrect image file: '.$file);
		}
		if ($a[2] != 2) {
			$this->Error('Not a JPEG file: '.$file);
		}
		// bits per pixel
		$bpc = isset($a['bits']) ? intval($a['bits']) : 8;
		// number of image channels
		if (!isset($a['channels'])) {
			$channels = 3;
		} else {
			$channels = intval($a['channels']);
		}
		// default colour space
		switch ($channels) {
			case 1: {
				$colspace = 'DeviceGray';
				break;
			}
			case 3: {
				$colspace = 'DeviceRGB';
				break;
			}
			case 4: {
				$colspace = 'DeviceCMYK';
				break;
			}
			default: {
				$channels = 3;
				$colspace = 'DeviceRGB';
				break;
			}
		}
		// get file content
		$data = file_get_contents($file);
		// check for embedded ICC profile
		$icc = array();
		$offset = 0;
		while (($pos = strpos($data, "ICC_PROFILE\0", $offset)) !== false) {
			// get ICC sequence length
			$length = ($this->_getUSHORT($data, ($pos - 2)) - 16);
			// marker sequence number
			$msn = max(1, ord($data[($pos + 12)]));
			// number of markers (total of APP2 used)
			$nom = max(1, ord($data[($pos + 13)]));
			// get sequence segment
			$icc[($msn - 1)] = substr($data, ($pos + 14), $length);
			// move forward to next sequence
			$offset = ($pos + 14 + $length);
		}
		// order and compact ICC segments
		if (count($icc) > 0) {
			ksort($icc);
			$icc = implode('', $icc);
			if ((ord($icc{36}) != 0x61) OR (ord($icc{37}) != 0x63) OR (ord($icc{38}) != 0x73) OR (ord($icc{39}) != 0x70)) {
				// invalid ICC profile
				$icc = false;
			}
		} else {
			$icc = false;
		}
		return array('w' => $a[0], 'h' => $a[1], 'ch' => $channels, 'icc' => $icc, 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'DCTDecode', 'data' => $data);
	}

	/**
	 * Extract info from a PNG file without using the GD library.
	 * @param $file (string) image file to parse
	 * @return array structure containing the image data
	 * @protected
	 */
	protected function _parsepng($file) {
		$f = fopen($file, 'rb');
		if ($f === false) {
			$this->Error('Can\'t open image file: '.$file);
		}
		//Check signature
		if (fread($f, 8) != chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10)) {
			$this->Error('Not a PNG file: '.$file);
		}
		//Read header chunk
		fread($f, 4);
		if (fread($f, 4) != 'IHDR') {
			$this->Error('Incorrect PNG file: '.$file);
		}
		$w = $this->_freadint($f);
		$h = $this->_freadint($f);
		$bpc = ord(fread($f, 1));
		if ($bpc > 8) {
			//$this->Error('16-bit depth not supported: '.$file);
			fclose($f);
			return false;
		}
		$ct = ord(fread($f, 1));
		if ($ct == 0) {
			$colspace = 'DeviceGray';
		} elseif ($ct == 2) {
			$colspace = 'DeviceRGB';
		} elseif ($ct == 3) {
			$colspace = 'Indexed';
		} else {
			// alpha channel
			fclose($f);
			return 'pngalpha';
		}
		if (ord(fread($f, 1)) != 0) {
			//$this->Error('Unknown compression method: '.$file);
			fclose($f);
			return false;
		}
		if (ord(fread($f, 1)) != 0) {
			//$this->Error('Unknown filter method: '.$file);
			fclose($f);
			return false;
		}
		if (ord(fread($f, 1)) != 0) {
			//$this->Error('Interlacing not supported: '.$file);
			fclose($f);
			return false;
		}
		fread($f, 4);
		$channels = ($ct == 2 ? 3 : 1);
		$parms = '/DecodeParms << /Predictor 15 /Colors '.$channels.' /BitsPerComponent '.$bpc.' /Columns '.$w.' >>';
		//Scan chunks looking for palette, transparency and image data
		$pal = '';
		$trns = '';
		$data = '';
		$icc = false;
		do {
			$n = $this->_freadint($f);
			$type = fread($f, 4);
			if ($type == 'PLTE') {
				// read palette
				$pal = $this->rfread($f, $n);
				fread($f, 4);
			} elseif ($type == 'tRNS') {
				// read transparency info
				$t = $this->rfread($f, $n);
				if ($ct == 0) {
					$trns = array(ord($t{1}));
				} elseif ($ct == 2) {
					$trns = array(ord($t{1}), ord($t{3}), ord($t{5}));
				} else {
					$pos = strpos($t, chr(0));
					if ($pos !== false) {
						$trns = array($pos);
					}
				}
				fread($f, 4);
			} elseif ($type == 'IDAT') {
				// read image data block
				$data .= $this->rfread($f, $n);
				fread($f, 4);
			} elseif ($type == 'iCCP') {
				// skip profile name and null separator
				$len = 0;
				while ((ord(fread($f, 1)) > 0) AND ($len < 80)) {
					++$len;
				}
				// get compression method
				if (ord(fread($f, 1)) != 0) {
					//$this->Error('Unknown filter method: '.$file);
					fclose($f);
					return false;
				}
				// read ICC Color Profile
				$icc = $this->rfread($f, ($n - $len - 2));
				// decompress profile
				$icc = gzuncompress($icc);
				fread($f, 4);
			} elseif ($type == 'IEND') {
				break;
			} else {
				$this->rfread($f, $n + 4);
			}
		} while ($n);
		if (($colspace == 'Indexed') AND (empty($pal))) {
			//$this->Error('Missing palette in '.$file);
			fclose($f);
			return false;
		}
		fclose($f);
		return array('w' => $w, 'h' => $h, 'ch' => $channels, 'icc' => $icc, 'cs' => $colspace, 'bpc' => $bpc, 'f' => 'FlateDecode', 'parms' => $parms, 'pal' => $pal, 'trns' => $trns, 'data' => $data);
	}

	/**
	 * Binary-safe and URL-safe file read.
	 * Reads up to length bytes from the file pointer referenced by handle. Reading stops as soon as one of the following conditions is met: length bytes have been read; EOF (end of file) is reached.
	 * @param $handle (resource)
	 * @param $length (int)
	 * @return Returns the read string or FALSE in case of error.
	 * @author Nicola Asuni
	 * @protected
	 * @since 4.5.027 (2009-03-16)
	 */
	protected function rfread($handle, $length) {
		$data = fread($handle, $length);
		if ($data === false) {
			return false;
		}
		$rest = $length - strlen($data);
		if ($rest > 0) {
			$data .= $this->rfread($handle, $rest);

		}
		return $data;
	}

	/**
	 * Extract info from a PNG image with alpha channel using the GD library.
	 * @param $file (string) Name of the file containing the image.
	 * @param $x (float) Abscissa of the upper-left corner.
	 * @param $y (float) Ordinate of the upper-left corner.
	 * @param $wpx (float) Original width of the image in pixels.
	 * @param $hpx (float) original height of the image in pixels.
	 * @param $w (float) Width of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $h (float) Height of the image in the page. If not specified or equal to zero, it is automatically calculated.
	 * @param $type (string) Image format. Possible values are (case insensitive): JPEG and PNG (whitout GD library) and all images supported by GD: GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM;. If not specified, the type is inferred from the file extension.
	 * @param $link (mixed) URL or identifier returned by AddLink().
	 * @param $align (string) Indicates the alignment of the pointer next to image insertion relative to image height. The value can be:<ul><li>T: top-right for LTR or top-left for RTL</li><li>M: middle-right for LTR or middle-left for RTL</li><li>B: bottom-right for LTR or bottom-left for RTL</li><li>N: next line</li></ul>
	 * @param $resize (boolean) If true resize (reduce) the image to fit $w and $h (requires GD library).
	 * @param $dpi (int) dot-per-inch resolution used on resize
	 * @param $palign (string) Allows to center or align the image on the current line. Possible values are:<ul><li>L : left align</li><li>C : center</li><li>R : right align</li><li>'' : empty string : left for LTR or right for RTL</li></ul>
	 * @param $filehash (string) File hash used to build unique file names.
	 * @author Nicola Asuni
	 * @protected
	 * @since 4.3.007 (2008-12-04)
	 * @see Image()
	 */
	protected function ImagePngAlpha($file, $x, $y, $wpx, $hpx, $w, $h, $type, $link, $align, $resize, $dpi, $palign, $filehash='') {
		if (empty($filehash)) {
			$filehash = md5($file);
		}
		// create temp image file (without alpha channel)
		$tempfile_plain = K_PATH_CACHE.'mskp_'.$filehash;
		// create temp alpha file
		$tempfile_alpha = K_PATH_CACHE.'mska_'.$filehash;
		if (extension_loaded('imagick')) { // ImageMagick extension
			// ImageMagick library
			$img = new Imagick();
			$img->readImage($file);
			// clone image object
			$imga = $img->clone();
			// extract alpha channel
			$img->separateImageChannel(8); // 8 = (imagick::CHANNEL_ALPHA | imagick::CHANNEL_OPACITY | imagick::CHANNEL_MATTE);
			$img->negateImage(true);
			$img->setImageFormat('png');
			$img->writeImage($tempfile_alpha);
			// remove alpha channel
			$imga->separateImageChannel(39); // 39 = (imagick::CHANNEL_ALL & ~(imagick::CHANNEL_ALPHA | imagick::CHANNEL_OPACITY | imagick::CHANNEL_MATTE));
			$imga->setImageFormat('png');
			$imga->writeImage($tempfile_plain);
		} elseif (function_exists('imagecreatefrompng')) { // GD extension
			// generate images
			$img = imagecreatefrompng($file);
			$imgalpha = imagecreate($wpx, $hpx);
			// generate gray scale palette (0 -> 255)
			for ($c = 0; $c < 256; ++$c) {
				ImageColorAllocate($imgalpha, $c, $c, $c);
			}
			// extract alpha channel
			for ($xpx = 0; $xpx < $wpx; ++$xpx) {
				for ($ypx = 0; $ypx < $hpx; ++$ypx) {
					$color = imagecolorat($img, $xpx, $ypx);
					$alpha = ($color >> 24); // shifts off the first 24 bits (where 8x3 are used for each color), and returns the remaining 7 allocated bits (commonly used for alpha)
					$alpha = (((127 - $alpha) / 127) * 255); // GD alpha is only 7 bit (0 -> 127)
					$alpha = $this->getGDgamma($alpha); // correct gamma
					imagesetpixel($imgalpha, $xpx, $ypx, $alpha);
				}
			}
			imagepng($imgalpha, $tempfile_alpha);
			imagedestroy($imgalpha);
			// extract image without alpha channel
			$imgplain = imagecreatetruecolor($wpx, $hpx);
			imagecopy($imgplain, $img, 0, 0, 0, 0, $wpx, $hpx);
			imagepng($imgplain, $tempfile_plain);
			imagedestroy($imgplain);
		} else {
			$this->Error('TCPDF requires the Imagick or GD extension to handle PNG images with alpha channel.');
		}
		// embed mask image
		$imgmask = $this->Image($tempfile_alpha, $x, $y, $w, $h, 'PNG', '', '', $resize, $dpi, '', true, false);
		// embed image, masked with previously embedded mask
		$this->Image($tempfile_plain, $x, $y, $w, $h, $type, $link, $align, $resize, $dpi, $palign, false, $imgmask);
		// remove temp files
		unlink($tempfile_alpha);
		unlink($tempfile_plain);
	}

	/**
	 * Correct the gamma value to be used with GD library
	 * @param $v (float) the gamma value to be corrected
	 * @protected
	 * @since 4.3.007 (2008-12-04)
	 */
	protected function getGDgamma($v) {
		return (pow(($v / 255), 2.2) * 255);
	}

	/**
	 * Performs a line break.
	 * The current abscissa goes back to the left margin and the ordinate increases by the amount passed in parameter.
	 * @param $h (float) The height of the break. By default, the value equals the height of the last printed cell.
	 * @param $cell (boolean) if true add the current left (or right o for RTL) padding to the X coordinate
	 * @public
	 * @since 1.0
	 * @see Cell()
	 */
	public function Ln($h='', $cell=false) {
		if (($this->num_columns > 1) AND ($this->y == $this->columns[$this->current_column]['y']) AND isset($this->columns[$this->current_column]['x']) AND ($this->x == $this->columns[$this->current_column]['x'])) {
			// revove vertical space from the top of the column
			return;
		}
		if ($cell) {
			if ($this->rtl) {
				$cellpadding = $this->cell_padding['R'];
			} else {
				$cellpadding = $this->cell_padding['L'];
			}
		} else {
			$cellpadding = 0;
		}
		if ($this->rtl) {
			$this->x = $this->w - $this->rMargin - $cellpadding;
		} else {
			$this->x = $this->lMargin + $cellpadding;
		}
		if (is_string($h)) {
			$this->y += $this->lasth;
		} else {
			$this->y += $h;
		}
		$this->newline = true;
	}

	/**
	 * Returns the relative X value of current position.
	 * The value is relative to the left border for LTR languages and to the right border for RTL languages.
	 * @return float
	 * @public
	 * @since 1.2
	 * @see SetX(), GetY(), SetY()
	 */
	public function GetX() {
		//Get x position
		if ($this->rtl) {
			return ($this->w - $this->x);
		} else {
			return $this->x;
		}
	}

	/**
	 * Returns the absolute X value of current position.
	 * @return float
	 * @public
	 * @since 1.2
	 * @see SetX(), GetY(), SetY()
	 */
	public function GetAbsX() {
		return $this->x;
	}

	/**
	 * Returns the ordinate of the current position.
	 * @return float
	 * @public
	 * @since 1.0
	 * @see SetY(), GetX(), SetX()
	 */
	public function GetY() {
		return $this->y;
	}

	/**
	 * Defines the abscissa of the current position.
	 * If the passed value is negative, it is relative to the right of the page (or left if language is RTL).
	 * @param $x (float) The value of the abscissa.
	 * @param $rtloff (boolean) if true always uses the page top-left corner as origin of axis.
	 * @public
	 * @since 1.2
	 * @see GetX(), GetY(), SetY(), SetXY()
	 */
	public function SetX($x, $rtloff=false) {
		if (!$rtloff AND $this->rtl) {
			if ($x >= 0) {
				$this->x = $this->w - $x;
			} else {
				$this->x = abs($x);
			}
		} else {
			if ($x >= 0) {
				$this->x = $x;
			} else {
				$this->x = $this->w + $x;
			}
		}
		if ($this->x < 0) {
			$this->x = 0;
		}
		if ($this->x > $this->w) {
			$this->x = $this->w;
		}
	}

	/**
	 * Moves the current abscissa back to the left margin and sets the ordinate.
	 * If the passed value is negative, it is relative to the bottom of the page.
	 * @param $y (float) The value of the ordinate.
	 * @param $resetx (bool) if true (default) reset the X position.
	 * @param $rtloff (boolean) if true always uses the page top-left corner as origin of axis.
	 * @public
	 * @since 1.0
	 * @see GetX(), GetY(), SetY(), SetXY()
	 */
	public function SetY($y, $resetx=true, $rtloff=false) {
		if ($resetx) {
			//reset x
			if (!$rtloff AND $this->rtl) {
				$this->x = $this->w - $this->rMargin;
			} else {
				$this->x = $this->lMargin;
			}
		}
		if ($y >= 0) {
			$this->y = $y;
		} else {
			$this->y = $this->h + $y;
		}
		if ($this->y < 0) {
			$this->y = 0;
		}
		if ($this->y > $this->h) {
			$this->y = $this->h;
		}
	}

	/**
	 * Defines the abscissa and ordinate of the current position.
	 * If the passed values are negative, they are relative respectively to the right and bottom of the page.
	 * @param $x (float) The value of the abscissa.
	 * @param $y (float) The value of the ordinate.
	 * @param $rtloff (boolean) if true always uses the page top-left corner as origin of axis.
	 * @public
	 * @since 1.2
	 * @see SetX(), SetY()
	 */
	public function SetXY($x, $y, $rtloff=false) {
		$this->SetY($y, false, $rtloff);
		$this->SetX($x, $rtloff);
	}

	/**
	 * Ouput input data and compress it if possible.
	 * @param $data (string) Data to output.
	 * @param $length (int) Data length in bytes.
	 * @protected
	 * @since 5.9.086
	 */
	protected function sendOutputData($data, $length) {
		if (!isset($_SERVER['HTTP_ACCEPT_ENCODING']) OR empty($_SERVER['HTTP_ACCEPT_ENCODING'])) {
			// the content length may vary if the server is using compression
			header('Content-Length: '.$length);
		}
		echo $data;
	}

	/**
	 * Send the document to a given destination: string, local file or browser.
	 * In the last case, the plug-in may be used (if present) or a download ("Save as" dialog box) may be forced.<br />
	 * The method first calls Close() if necessary to terminate the document.
	 * @param $name (string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
	 * @param $dest (string) Destination where to send the document. It can take one of the following values:<ul><li>I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.</li><li>D: send to the browser and force a file download with the name given by name.</li><li>F: save to a local server file with the name given by name.</li><li>S: return the document as a string (name is ignored).</li><li>FI: equivalent to F + I option</li><li>FD: equivalent to F + D option</li><li>E: return the document as base64 mime multi-part email attachment (RFC 2045)</li></ul>
	 * @public
	 * @since 1.0
	 * @see Close()
	 */
	public function Output($name='doc.pdf', $dest='I') {
		//Output PDF to some destination
		//Finish document if necessary
		if ($this->state < 3) {
			$this->Close();
		}
		//Normalize parameters
		if (is_bool($dest)) {
			$dest = $dest ? 'D' : 'F';
		}
		$dest = strtoupper($dest);
		if ($dest{0} != 'F') {
			$name = preg_replace('/[\s]+/', '_', $name);
			$name = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $name);
		}
		if ($this->sign) {
			// *** apply digital signature to the document ***
			// get the document content
			$pdfdoc = $this->getBuffer();
			// remove last newline
			$pdfdoc = substr($pdfdoc, 0, -1);
			// Remove the original buffer
			if (isset($this->diskcache) AND $this->diskcache) {
				// remove buffer file from cache
				unlink($this->buffer);
			}
			unset($this->buffer);
			// remove filler space
			$byterange_string_len = strlen($this->byterange_string);
			// define the ByteRange
			$byte_range = array();
			$byte_range[0] = 0;
			$byte_range[1] = strpos($pdfdoc, $this->byterange_string) + $byterange_string_len + 10;
			$byte_range[2] = $byte_range[1] + $this->signature_max_length + 2;
			$byte_range[3] = strlen($pdfdoc) - $byte_range[2];
			$pdfdoc = substr($pdfdoc, 0, $byte_range[1]).substr($pdfdoc, $byte_range[2]);
			// replace the ByteRange
			$byterange = sprintf('/ByteRange[0 %u %u %u]', $byte_range[1], $byte_range[2], $byte_range[3]);
			$byterange .= str_repeat(' ', ($byterange_string_len - strlen($byterange)));
			$pdfdoc = str_replace($this->byterange_string, $byterange, $pdfdoc);
			// write the document to a temporary folder
			$tempdoc = tempnam(K_PATH_CACHE, 'tmppdf_');
			$f = fopen($tempdoc, 'wb');
			if (!$f) {
				$this->Error('Unable to create temporary file: '.$tempdoc);
			}
			$pdfdoc_length = strlen($pdfdoc);
			fwrite($f, $pdfdoc, $pdfdoc_length);
			fclose($f);
			// get digital signature via openssl library
			$tempsign = tempnam(K_PATH_CACHE, 'tmpsig_');
			if (empty($this->signature_data['extracerts'])) {
				openssl_pkcs7_sign($tempdoc, $tempsign, $this->signature_data['signcert'], array($this->signature_data['privkey'], $this->signature_data['password']), array(), PKCS7_BINARY | PKCS7_DETACHED);
			} else {
				openssl_pkcs7_sign($tempdoc, $tempsign, $this->signature_data['signcert'], array($this->signature_data['privkey'], $this->signature_data['password']), array(), PKCS7_BINARY | PKCS7_DETACHED, $this->signature_data['extracerts']);
			}
			unlink($tempdoc);
			// read signature
			$signature = file_get_contents($tempsign);
			unlink($tempsign);
			// extract signature
			$signature = substr($signature, $pdfdoc_length);
			$signature = substr($signature, (strpos($signature, "%%EOF\n\n------") + 13));
			$tmparr = explode("\n\n", $signature);
			$signature = $tmparr[1];
			unset($tmparr);
			// decode signature
			$signature = base64_decode(trim($signature));
			// convert signature to hex
			$signature = current(unpack('H*', $signature));
			$signature = str_pad($signature, $this->signature_max_length, '0');
			// disable disk caching
			$this->diskcache = false;
			// Add signature to the document
			$this->buffer = substr($pdfdoc, 0, $byte_range[1]).'<'.$signature.'>'.substr($pdfdoc, $byte_range[1]);
			$this->bufferlen = strlen($this->buffer);
		}
		switch($dest) {
			case 'I': {
				// Send PDF to the standard output
				if (ob_get_contents()) {
					$this->Error('Some data has already been output, can\'t send PDF file');
				}
				if (php_sapi_name() != 'cli') {
					// send output to a browser
					header('Content-Type: application/pdf');
					if (headers_sent()) {
						$this->Error('Some data has already been output to browser, can\'t send PDF file');
					}
					header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
					//header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
					header('Pragma: public');
					header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
					header('Content-Disposition: inline; filename="'.basename($name).'";');
					$this->sendOutputData($this->getBuffer(), $this->bufferlen);
				} else {
					echo $this->getBuffer();
				}
				break;
			}
			case 'D': {
				// download PDF as file
				if (ob_get_contents()) {
					$this->Error('Some data has already been output, can\'t send PDF file');
				}
				header('Content-Description: File Transfer');
				if (headers_sent()) {
					$this->Error('Some data has already been output to browser, can\'t send PDF file');
				}
				header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
				//header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
				header('Pragma: public');
				header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
				header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
				// force download dialog
				if (strpos(php_sapi_name(), 'cgi') === false) {
					header('Content-Type: application/force-download');
					header('Content-Type: application/octet-stream', false);
					header('Content-Type: application/download', false);
					header('Content-Type: application/pdf', false);
				} else {
					header('Content-Type: application/pdf');
				}
				// use the Content-Disposition header to supply a recommended filename
				header('Content-Disposition: attachment; filename="'.basename($name).'";');
				header('Content-Transfer-Encoding: binary');
				$this->sendOutputData($this->getBuffer(), $this->bufferlen);
				break;
			}
			case 'F':
			case 'FI':
			case 'FD': {
				// save PDF to a local file
				if ($this->diskcache) {
					copy($this->buffer, $name);
				} else {
					$f = fopen($name, 'wb');
					if (!$f) {
						$this->Error('Unable to create output file: '.$name);
					}
					fwrite($f, $this->getBuffer(), $this->bufferlen);
					fclose($f);
				}
				if ($dest == 'FI') {
					// send headers to browser
					header('Content-Type: application/pdf');
					header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
					//header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
					header('Pragma: public');
					header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
					header('Content-Disposition: inline; filename="'.basename($name).'";');
					$this->sendOutputData(file_get_contents($name), filesize($name));
				} elseif ($dest == 'FD') {
					// send headers to browser
					if (ob_get_contents()) {
						$this->Error('Some data has already been output, can\'t send PDF file');
					}
					header('Content-Description: File Transfer');
					if (headers_sent()) {
						$this->Error('Some data has already been output to browser, can\'t send PDF file');
					}
					header('Cache-Control: private, must-revalidate, post-check=0, pre-check=0, max-age=1');
					header('Pragma: public');
					header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
					// force download dialog
					if (strpos(php_sapi_name(), 'cgi') === false) {
						header('Content-Type: application/force-download');
						header('Content-Type: application/octet-stream', false);
						header('Content-Type: application/download', false);
						header('Content-Type: application/pdf', false);
					} else {
						header('Content-Type: application/pdf');
					}
					// use the Content-Disposition header to supply a recommended filename
					header('Content-Disposition: attachment; filename="'.basename($name).'";');
					header('Content-Transfer-Encoding: binary');
					$this->sendOutputData(file_get_contents($name), filesize($name));
				}
				break;
			}
			case 'E': {
				// return PDF as base64 mime multi-part email attachment (RFC 2045)
				$retval = 'Content-Type: application/pdf;'."\r\n";
				$retval .= ' name="'.$name.'"'."\r\n";
				$retval .= 'Content-Transfer-Encoding: base64'."\r\n";
				$retval .= 'Content-Disposition: attachment;'."\r\n";
				$retval .= ' filename="'.$name.'"'."\r\n\r\n";
				$retval .= chunk_split(base64_encode($this->getBuffer()), 76, "\r\n");
				return $retval;
			}
			case 'S': {
				// returns PDF as a string
				return $this->getBuffer();
			}
			default: {
				$this->Error('Incorrect output destination: '.$dest);
			}
		}
		return '';
	}

	/**
	 * Unset all class variables except the following critical variables: internal_encoding, state, bufferlen, buffer and diskcache.
	 * @param $destroyall (boolean) if true destroys all class variables, otherwise preserves critical variables.
	 * @param $preserve_objcopy (boolean) if true preserves the objcopy variable
	 * @public
	 * @since 4.5.016 (2009-02-24)
	 */
	public function _destroy($destroyall=false, $preserve_objcopy=false) {
		if ($destroyall AND isset($this->diskcache) AND $this->diskcache AND (!$preserve_objcopy) AND (!$this->empty_string($this->buffer))) {
			// remove buffer file from cache
			unlink($this->buffer);
		}
		foreach (array_keys(get_object_vars($this)) as $val) {
			if ($destroyall OR (
				($val != 'internal_encoding')
				AND ($val != 'state')
				AND ($val != 'bufferlen')
				AND ($val != 'buffer')
				AND ($val != 'diskcache')
				AND ($val != 'sign')
				AND ($val != 'signature_data')
				AND ($val != 'signature_max_length')
				AND ($val != 'byterange_string')
				)) {
				if ((!$preserve_objcopy OR ($val != 'objcopy')) AND isset($this->$val)) {
					unset($this->$val);
				}
			}
		}
	}

	/**
	 * Check for locale-related bug
	 * @protected
	 */
	protected function _dochecks() {
		//Check for locale-related bug
		if (1.1 == 1) {
			$this->Error('Don\'t alter the locale before including class file');
		}
		//Check for decimal separator
		if (sprintf('%.1F', 1.0) != '1.0') {
			setlocale(LC_NUMERIC, 'C');
		}
	}

	/**
	 * Return fonts path
	 * @return string
	 * @protected
	 */
	protected function _getfontpath() {
		if (!defined('K_PATH_FONTS') AND is_dir(dirname(__FILE__).'/fonts')) {
			define('K_PATH_FONTS', dirname(__FILE__).'/fonts/');
		}
		return defined('K_PATH_FONTS') ? K_PATH_FONTS : '';
	}

	/**
	 * Return an array containing variations for the basic page number alias.
	 * @param $a (string) Base alias.
	 * @return array of page number aliases
	 * @protected
	 */
	protected function getInternalPageNumberAliases($a= '') {
		$alias = array();
		// build array of Unicode + ASCII variants (the order is important)
		$alias = array('u' => array(), 'a' => array());
		$u = '{'.$a.'}';
		$alias['u'][] = $this->_escape($u);
		if ($this->isunicode) {
			$alias['u'][] = $this->_escape($this->UTF8ToLatin1($u));
			$alias['u'][] = $this->_escape($this->utf8StrRev($u, false, $this->tmprtl));
			$alias['a'][] = $this->_escape($this->UTF8ToLatin1($a));
			$alias['a'][] = $this->_escape($this->utf8StrRev($a, false, $this->tmprtl));
		}
		$alias['a'][] = $this->_escape($a);
		return $alias;
	}

	/**
	 * Return an array containing all internal page aliases.
	 * @return array of page number aliases
	 * @protected
	 */
	protected function getAllInternalPageNumberAliases() {
		$basic_alias = array($this->alias_tot_pages, $this->alias_num_page, $this->alias_group_tot_pages, $this->alias_group_num_page, $this->alias_right_shift);
		$pnalias = array();
		foreach($basic_alias as $k => $a) {
			$pnalias[$k] = $this->getInternalPageNumberAliases($a);
		}
		return $pnalias;
	}

	/**
	 * Replace page number aliases with number.
	 * @param $page (string) Page content.
	 * @param $replace (array) Array of replacements (array keys are replacement strings, values are alias arrays).
	 * @param $diff (int) If passed, this will be set to the total char number difference between alias and replacements.
	 * @return replaced page content and updated $diff parameter as array.
	 * @protected
	 */
	protected functio