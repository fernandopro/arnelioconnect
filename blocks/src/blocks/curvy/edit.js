/**
 * Retrieves the translation of text.
 * * CURVY BLOCK
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

console.log("block curvy - Back: archivo edit.js!");

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl, SelectControl } from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
import metadata from './block.json';
import { Curve } from './components/curve';

export default function Edit(props) {
	console.log("props: ", props)

    // Obtener las propiedades del bloque
    const blockProps = useBlockProps();

    // Desestructurar las clases y otras propiedades
    const { className, ...otherProps } = blockProps;

    // Eliminar la clase 'wp-block'
    const filteredClassName = className
        .split(' ')
        .filter(cls => cls !== 'wp-block')
        .join(' ');


	return (
		<>
			<section className={filteredClassName} {...otherProps}>
				{props.attributes.enableTopCurve && <Curve />}
			</section>
			<InspectorControls>
				<PanelBody title={ __( 'Top curve', metadata.textdomain ) }>
					<div className="topCurveLabel">
						<ToggleControl onChange={(isCheked) =>{
							props.setAttributes({enableTopCurve: isCheked});
						}} checked={props.attributes.enableTopCurve} />
							<span>{ __( 'Enable top curve', metadata.textdomain ) }</span>
					</div>
					<div className="enableSelectTarot">
						
                        <ToggleControl 
                            onChange={(isCheked) => {
                                props.setAttributes({ enableSelectTarot: isCheked });
                            }} 
                            checked={props.attributes.enableSelectTarot} 
                        />
                        <span>{ __( 'Enable Tarots', metadata.textdomain ) }</span>
						</div>
						<div className="select-tarot-container">
							{props.attributes.enableSelectTarot && (
								<div className="select-tarot-container">
									<label className="select-tarot-label">
										{ __( 'Select a Tarot', metadata.textdomain ) }
									</label>
									<SelectControl
										value={ props.attributes.selectedTarot }
										options={ [
											{ label: 'Tarot 1', value: 'tarot1' },
											{ label: 'Tarot 2', value: 'tarot2' },
											{ label: 'Tarot 3', value: 'tarot3' },
										] }
										onChange={ (selectedTarot) => {
											props.setAttributes({ selectedTarot });
										} }
									/>
								</div>
							)}
						</div>

                        
                   
				</PanelBody>
			</InspectorControls>
		</>
	);
}
