import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SearchControl } from '@wordpress/components';	
import { useState, useEffect } from 'react';
import metadata from './block.json';
import './editor.scss';
import { translations } from './translations';

export default function Edit({ attributes, setAttributes }) {
    const [searchTerm, setSearchTerm] = useState(attributes.selectedTarot || '');
    const [posts, setPosts] = useState([]);
    const [isPostSelected, setIsPostSelected] = useState(!!attributes.selectedTarot);

    useEffect(() => {
        fetch('/wp-json/wp/v2/scfs_tarots?status=publish')
            .then(response => response.json())
            .then(data => {
                console.log('Datos obtenidos:', data);
                setPosts(data);
            })
            .catch(error => {
                console.error('Error fetching posts:', error);
            });
    }, []);

    const filteredPosts = posts.filter((post) =>
        post.title.rendered.toLowerCase().includes(searchTerm.toLowerCase())
    );

    const onChangeSearch = (value) => {
        setSearchTerm(value);
        setIsPostSelected(false);
    };

    const onSelectPost = (postTitle, postId, postSlug) => {
        setSearchTerm(postTitle);
        setAttributes({ selectedTarot: postTitle, idTarot: postId, slugTarot: postSlug });
        setIsPostSelected(true);
        console.log('Selected post:', postTitle, 'ID:', postId, 'Slug:', postSlug);
    };

    return (
        <div { ...useBlockProps() }>
            <div className='nameShortcode'>Tarokina Block</div>
            <SearchControl
                value={searchTerm}
                onChange={onChangeSearch}
                placeholder={translations.search + '...'}
            />
            {searchTerm && filteredPosts.length > 0 && !isPostSelected && (
                <ul id="filterContent">
                    {filteredPosts.map((post) => (
                        <li key={post.id} onClick={() => onSelectPost(post.title.rendered, post.id, post.slug)}>
                            {post.title.rendered}
                        </li>
                    ))}
                </ul>
            )}
        </div>
    );
}