import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const {
		mediaUrl,
		mediaAlt,
		heading,
		bodyText,
		buttonLabel,
		buttonUrl,
		buttonColor,
	} = attributes;

	const blockProps = useBlockProps.save( { className: 'info-card' } );

	return (
		<div { ...blockProps }>
			{ mediaUrl && (
				<div className="info-card__image-wrap">
					<img
						src={ mediaUrl }
						alt={ mediaAlt }
						className="info-card__image"
					/>
				</div>
			) }
			<div className="info-card__content">
				<RichText.Content
					tagName="h3"
					className="info-card__heading"
					value={ heading }
				/>
				<RichText.Content
					tagName="p"
					className="info-card__body"
					value={ bodyText }
				/>
				<a
					href={ buttonUrl }
					className="info-card__button"
					style={ { backgroundColor: buttonColor } }
				>
					<RichText.Content value={ buttonLabel } />
				</a>
			</div>
		</div>
	);
}
