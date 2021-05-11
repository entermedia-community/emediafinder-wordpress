/**
 * BLOCK: emedia-finder
 *
 * Block will open a gallery rendered on your server
 */

//  Import CSS.
import './editor.scss';
import './style.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

const { ToggleControl, PanelBody, PanelRow, CheckboxControl, SelectControl, ColorPicker, TextControl, RangeControl } = wp.components;
const { RichText, InspectorControls } = wp.blockEditor;


registerBlockType('cgb/block-emedia-finder', {
	title: __('eMediaFinder'),
	icon: 'format-gallery',
	category: 'common',
	keywords: [
		__('emedia-finder'),
		__('entermedia'),
		__('emediafinder'),
	],
	attributes: {
		url: { type: 'string' },
		emInputId: { type: 'string' },
		myRichHeading: { type: 'string', },
		imageText: { type: 'string' },
		imageTextSize: { type: 'string', default: '' },
		hasBackground: { type: 'boolean', default: false },
		favoriteColor: { type: 'string', default: '#DDDDDD' },
		activateLasers: { type: 'boolean', default: false },
		galleryType: { type: 'number', default: 0 }, // 0 image, 1 gallery, 2 video
		galleryColSize: { type: 'number', default: 2 },
		showEmailMsg: { type: 'boolean', default: false }
	},

	/**
	 * Gallery that shows assets on your server
	 *
	 * @link https://emediafinder.org/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Component.
	 */
	edit: (props) => {
		// vars
		const { attributes, setAttributes } = props;
		const cookieName = 'mediafinderkey';
		const loggedUser = credentials.emediafinderdb_current_wp_user.data.user_email;
		const blockHeader = // Block header
			<div class="components-placeholder__label">
				<span class="block-editor-block-icon">
					<svg width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false">
						<path
							d="M18.7 3H5.3C4 3 3 4 3 5.3v13.4C3 20 4 21 5.3 21h13.4c1.3 0 2.3-1 2.3-2.3V5.3C21 4 20 3 18.7 3zm.8 15.7c0 .4-.4.8-.8.8H5.3c-.4 0-.8-.4-.8-.8V5.3c0-.4.4-.8.8-.8h6.2v8.9l2.5-3.1 2.5 3.1V4.5h2.2c.4 0 .8.4.8.8v13.4z">
						</path>
					</svg>
				</span>
			eMedia Finder
			</div>;

		var inputId = props.attributes.emInputId;


		// making sure jquery works on both $ and jQuery
		$ = jQuery;

		/*
		* Creation of simple guid to make each block unique
		*/
		function guid() {
			const S4 = function () {
				return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
			};
			return (S4() + S4() + S4() + S4() + S4() + S4() + S4() + S4());
		}

		/*
		* save url value
		*/
		function SaveUrl(event) { props.setAttributes({ url: event.target.value }); }
		function CheckForChanges() {
			if (checker) { clearInterval(checker); }
			var checker = setInterval(() => {
				const current = document.getElementById(inputId);
				if (props.attributes.url !== current.value && current.value !== '') {
					setAttributes({ url: current.value });
					clearInterval(checker);
				}
			}, 1000);
		}

		/*
		* cookie managers
		* Leaving commented code, in case we need it in the future
		function GetCookie(cookieId) {
			var dc = document.cookie;
			var prefix = cookieId + "=";
			var begin = dc.indexOf("; " + prefix);
			if (begin == -1) {
				begin = dc.indexOf(prefix);
				if (begin != 0) return null;
			}
			else {
				begin += 2;
				var end = document.cookie.indexOf(";", begin);
				if (end == -1) {
					end = dc.length;
				}
			}
			return decodeURI(dc.substring(begin + prefix.length, end));
		}
		function RemoveCookie(cookieId) {
			if (GetCookie(cookieId)) {
				document.cookie = cookieId + '=; Max-Age=-99999999;';
			}
		}
		*/

		/*
		* SideBar setup for the image
		* includes, columns display (in case of multiple images)
		* Image Text, in the center of the image
		* font seetings
		* image color background
		*/
		function SideMenu() {
			const galleryOpt = attributes.galleryType === 1 ? (
				<PanelBody title="Gallery Settings" initialOpen={true}>
					<PanelRow>
						<RangeControl
							label="Columns"
							onChange={newval => { setAttributes({ galleryColSize: newval }) }}
							value={attributes.galleryColSize}
							min={1}
							max={8}
						/>
					</PanelRow>
				</PanelBody>
			) : null;
			const imageTextOpt = attributes.galleryType === 0 ? (
				<PanelBody title="Image Text" initialOpen={true}>
					<PanelRow>
						<TextControl
							label="Title"
							format="string"
							onChange={(newval) => setAttributes({ imageText: newval })}
							value={attributes.imageText}
						/>
					</PanelRow>
					<PanelRow>
						<div class="row">
							<div class="col-sm-8">Font Size</div>
							<div class="col-sm-4">Custom</div>
							<div class="col-sm-8">
								<SelectControl
									value={attributes.imageTextSize}
									options={[
										{ label: "Default", value: '' },
										{ label: "Small", value: '18' },
										{ label: "Regular", value: '21' },
										{ label: "Large", value: '26.5' },
										{ label: "Larger", value: '32' }
									]}
									onChange={(newval) => { setAttributes({ imageTextSize: newval }) }}
								/>
							</div>
							<div class="col-sm-4">
								<TextControl
									format="number"
									onChange={(newval) => setAttributes({ imageTextSize: newval })}
									value={attributes.imageTextSize}
								/>
							</div>
						</div>
					</PanelRow>
					<PanelRow>

					</PanelRow>
				</PanelBody>
			) : null;
			const imageCoverOpt = attributes.galleryType === 0 ? (
				<PanelBody title="Cover Settings" initialOpen={true}>
					<PanelRow>
						<ToggleControl
							label="Enable Cover Mode"
							checked={attributes.hasBackground}
							onChange={(newval) => setAttributes({ hasBackground: newval })}
						/>
					</PanelRow>
					<PanelRow>
						<ColorPicker
							color={attributes.favoriteColor}
							onChangeComplete={(newval) => setAttributes({ favoriteColor: newval.hex })}
							disableAlpha
						/>
					</PanelRow>
				</PanelBody>
			) : null;
			return (
				<InspectorControls>
					{galleryOpt}
					{imageTextOpt}
					{imageCoverOpt}
				</InspectorControls>);
		}

		/*
		* Show selected Image on edit. close to what it will look like in the public block
		*/
		function ShowSelectedImage() {
			var urls = [];
			var isVideo = false;
			if (props.attributes.url) {
				urls = props.attributes.url.toString().split(',');
				isVideo = urls[0].indexOf("videohls") > 0 || urls[0].indexOf("previewffmpeg") > 0 ? true : false;
			}
			var content = <div></div>;
			if (isVideo) {
				const vidStyle = {
					display: "block", borderStyle: "none"
				};
				content = (
					<div>
						<iframe src={urls[0]} allowfullscreen="true" width="600" height="450" style={vidStyle}></iframe>
					</div>
				);
			} else
				if (props.attributes.hasBackground || props.attributes.url) {
					if (urls.length === 1) {
						const styleUrl = props.attributes.hasBackground ? {
							backgroundColor: props.attributes.favoriteColor,
							backgroundImage: `url("${urls[0]}")`
						} : { backgroundImage: `url("${urls[0]}")` };
						const textStyle = props.attributes.imageText ? { fontSize: `${props.attributes.imageTextSize}px` } : {};
						const backgroundClass = "wp-block-cover has-subtle-background-background-color" + (props.attributes.hasBackground ? " has-background-dim" : "");
						if (props.attributes.galleryType !== 0) { setAttributes({ galleryType: 0 }); }
						content = (<div class={backgroundClass} style={styleUrl}>
							<div class="wp-block-cover__inner-container">
								<p class="has-text-align-center" style={textStyle}>{props.attributes.imageText}</p>
							</div>
						</div>);
					}
					if (urls.length > 1) {
						if (props.attributes.galleryType !== 1) { props.setAttributes({ galleryType: 1 }); }
						const galleryClass = `wp-block-gallery columns-${props.attributes.galleryColSize} is-cropped`;
						content = (
							<div class="wp-block-group__inner-container">
								<figure class={galleryClass}>
									<ul class="blocks-gallery-grid">
										{urls.map((u) => (
											<li class="blocks-gallery-item" >
												<figure class="is-selected">
													<img loading="lazy" src={u} alt="" data-id="246" class="wp-image-246" sizes="(max-width: 1024px) 100vw, 1024px" width="1024" height="576" />
												</figure>
											</li>
										))}
									</ul>
								</figure>
							</div>
						);
					}
				}
			return content;
		}

		/*
		* Main Block, containg buttons that will bring up the main modals for selecting assets
		*/
		function EmBox() {
			const href = `${credentials.emediafinderdb_cdn_prefix}/finder/blockfind/index.html`;
			const hrefUpload = `${credentials.emediafinderdb_cdn_prefix}/finder/blockfind/views/modules/asset/add/start.html`;
			const linkGalleryId = `gallery${attributes.emInputId}`;
			const linkUploadId = `upload${attributes.emInputId}`;
			return (
				<body>
					{SideMenu()}
					{ShowSelectedImage()}
					<div class="components-placeholder block-editor-media-placeholder is-large">
						{blockHeader}
						<input id={inputId} type="text" class="form-control" value={props.attributes.url} onChange={SaveUrl} hidden />

						<div class="components-placeholder__instructions">Search an image or video file, or pick one from your media library.</div>
						<div class="components-placeholder__fieldset">
							<div class="components-drop-zone"></div>
							<div class="components-form-file-upload">
								<a href="" class="emediafinder components-button is-primary" onClick={CheckForChanges} id={linkUploadId} data-emhref={hrefUpload} data-email={loggedUser}
									data-emkey={credentials.emediafinderdb_adminkey} data-inputidupload={attributes.emInputId} data-collectionid={credentials.emediafinderdb_collectionid}>Uploader</a>
								<a href="" class="emediafinder components-button is-tertiary" onClick={CheckForChanges} id={linkGalleryId} data-emhref={href} data-email={loggedUser}
									data-emkey={credentials.emediafinderdb_adminkey} data-inputidupload={attributes.emInputId} data-collectionid={credentials.emediafinderdb_collectionid}>View Finder</a>
							</div>
						</div>
					</div>
				</body>
			);
		}

		/*
		* Error Displaying Missing Configuration on Settings site
		*/
		function MissingSettings(msg) {
			const url = `${location.protocol}//${location.hostname}${(location.port ? ':' + location.port : '')}/wp-admin/options-general.php?page=emdb-publish`;
			return (
				<body>
					<div class="components-placeholder block-editor-media-placeholder is-large">
						{blockHeader}
						<div class="components-placeholder__instructions">An error was detected:</div>
						<div class="alert alert-warning">{msg}</div>
						<a href={url}>WordPress eMedia Finder Settings</a>
					</div>
				</body>
			);
		}

		/*
		* Leaving http POST|GET commented code. for the future
		function HttpPost(url, data) {
			const requestOptions = {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(data)
			};
			return fetch(url, requestOptions);
		}

		function HttpGet(url) {
			const headers = { 'Content-Type': 'application/json' }
			return fetch(url, { headers });
		}
		function ValidateKey() {
			const validateUrl = `${credentials.emediafinderdb_cdn_prefix}/finder/mediadb/services/settings/users/data/admin?entermediadb.key=${emKey}`;
			return true;
		}
		*/

		// assigning unique value to url input (in case of multiple blocks)
		if (!props.attributes.emInputId) { props.setAttributes({ emInputId: `em${guid()}` }); }
		// Configuration Checks
		if (!credentials.emediafinderdb_adminkey) { return MissingSettings("Missing access key, please click below for configuring access key in wordpress configuration, or ask wordpress administrator"); }
		if (!credentials.emediafinderdb_current_wp_user) { return MissingSettings("Email is not present on wordpress configuration"); }

		// checking all settings are configured properly
		if (credentials.emediafinderdb_cdn_prefix && credentials.emediafinderdb_entermediakey && credentials.emediafinderdb_collectionid) { return EmBox(); }

		// in case a configuration is missing
		return MissingSettings('You must configure all required settings for eMediaFinder in Wordpress settings');
	},

	/**
	 * public block
	 * @link https://emediafinder.com/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Frontend HTML.
	 */
	save: (props) => {
		/*
		* Simple view, showing images or video from saved URL using editor
		*/
		function ShowSelectedImage() {
			var urls = [];
			var isVideo = false;
			if (props.attributes.url) {
				urls = props.attributes.url.toString().split(',');
				isVideo = urls[0].indexOf("videohls") > 0 ? true : false;
			}
			var content = <div></div>;
			if (isVideo) {
				const vidStyle = {
					display: "block", borderStyle: "none"
				};
				content = (
					<div>
						<iframe src={urls[0]} allowfullscreen="true" width="600" height="450" style={vidStyle}></iframe>
					</div>
				);
			} else
				if (props.attributes.hasBackground || props.attributes.url) {
					if (urls.length === 1) {
						const styleUrl = props.attributes.hasBackground ? {
							backgroundColor: props.attributes.favoriteColor,
							backgroundImage: `url("${urls[0]}")`
						} : { backgroundImage: `url("${urls[0]}")` };
						const textStyle = props.attributes.imageText ? { fontSize: `${props.attributes.imageTextSize}px` } : {};
						const backgroundClass = "wp-block-cover has-subtle-background-background-color" + (props.attributes.hasBackground ? " has-background-dim" : "");
						if (props.attributes.galleryType !== 0) { setAttributes({ galleryType: 0 }); }
						content = (<div class={backgroundClass} style={styleUrl}>
							<div class="wp-block-cover__inner-container">
								<p class="has-text-align-center" style={textStyle}>{props.attributes.imageText}</p>
							</div>
						</div>);
					}
					if (urls.length > 1) {
						if (props.attributes.galleryType !== 1) { props.setAttributes({ galleryType: 1 }); }
						const galleryClass = `wp - block - gallery columns - ${props.attributes.galleryColSize} is - cropped`;
						content = (
							<div class="wp-block-group__inner-container">
								<figure class={galleryClass}>
									<ul class="blocks-gallery-grid">
										{urls.map((u) => (
											<li class="blocks-gallery-item" >
												<figure>
													<img loading="lazy" src={u} alt="" data-id="246" class="wp-image-246" sizes="(max-width: 1024px) 100vw, 1024px" width="1024" height="576" />
												</figure>
											</li>
										))}
									</ul>
								</figure>
							</div>
						);
					}
				}
			return content;
		}
		return (
			<body>{ShowSelectedImage()}</body>
		);
	},
});