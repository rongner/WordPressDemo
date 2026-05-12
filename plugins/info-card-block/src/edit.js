import { useBlockProps, RichText, MediaUpload, MediaUploadCheck, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit( { attributes, setAttributes } ) {
	const {
		mediaId,
		mediaUrl,
		mediaAlt,
		heading,
		bodyText,
		buttonLabel,
		buttonUrl,
		buttonColor,
	} = attributes;

	const blockProps = useBlockProps( { className: 'info-card' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Button Settings', 'info-card-block' ) }>
					<TextControl
						label={ __( 'Button URL', 'info-card-block' ) }
						value={ buttonUrl }
						onChange={ ( val ) => setAttributes( { buttonUrl: val } ) }
					/>
					<div>
						<label
							htmlFor="info-card-button-color"
							style={ { display: 'block', marginBottom: '4px', fontWeight: 600 } }
						>
							{ __( 'Button Color', 'info-card-block' ) }
						</label>
						<input
							id="info-card-button-color"
							type="color"
							value={ buttonColor }
							onChange={ ( e ) => setAttributes( { buttonColor: e.target.value } ) }
						/>
					</div>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="info-card__image-wrap">
					{ mediaUrl ? (
						<>
							<img
								src={ mediaUrl }
								alt={ mediaAlt }
								className="info-card__image"
							/>
							<Button
								className="info-card__upload-btn"
								variant="secondary"
								isSmall
								onClick={ () => setAttributes( { mediaId: 0, mediaUrl: '', mediaAlt: '' } ) }
							>
								{ __( 'Remove Image', 'info-card-block' ) }
							</Button>
						</>
					) : (
						<MediaUploadCheck>
							<MediaUpload
								onSelect={ ( media ) =>
									setAttributes( {
										mediaId: media.id,
										mediaUrl: media.url,
										mediaAlt: media.alt || '',
									} )
								}
								allowedTypes={ [ 'image' ] }
								value={ mediaId }
								render={ ( { open } ) => (
									<div className="info-card__placeholder">
										<Button variant="primary" onClick={ open }>
											{ __( 'Select Image', 'info-card-block' ) }
										</Button>
									</div>
								) }
							/>
						</MediaUploadCheck>
					) }
				</div>

				<div className="info-card__content">
					<RichText
						tagName="h3"
						className="info-card__heading"
						value={ heading }
						onChange={ ( val ) => setAttributes( { heading: val } ) }
						placeholder={ __( 'Card Heading', 'info-card-block' ) }
					/>
					<RichText
						tagName="p"
						className="info-card__body"
						value={ bodyText }
						onChange={ ( val ) => setAttributes( { bodyText: val } ) }
						placeholder={ __( 'Add a description…', 'info-card-block' ) }
					/>
					<RichText
						tagName="a"
						className="info-card__button"
						value={ buttonLabel }
						onChange={ ( val ) => setAttributes( { buttonLabel: val } ) }
						placeholder={ __( 'Learn More', 'info-card-block' ) }
						style={ { backgroundColor: buttonColor } }
						allowedFormats={ [] }
					/>
				</div>
			</div>
		</>
	);
}
