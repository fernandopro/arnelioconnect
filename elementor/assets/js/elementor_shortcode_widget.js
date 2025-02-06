//  CSS
import '../scss/elementor_shortcode_widget.scss';

//  SweetAlert2
//import Swal from 'sweetalert2';

console.log("elementor_shortcode_widget js");

document.addEventListener('DOMContentLoaded', function() {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1 && node.querySelector('#search_text')) {
                        initializeSearchWidget(node);
                    }
                });
            }
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });

    function initializeSearchWidget(container) {
        const searchInput = container.querySelector('#search_text');
        const searchResults = container.querySelector('#search_results');
        const hiddenInput = container.querySelector('#search_id');
        let posts = [];

        // Fetch posts from the API
        fetch('/wp-json/wp/v2/scfs_tarots?status=publish')
            .then(response => response.json())
            .then(data => {
                posts = data;
            })
            .catch(error => {
                console.error('Error fetching posts:', error);
            });

        // Handle search input change
        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const filteredPosts = posts.filter(post => post.title.rendered.toLowerCase().includes(searchTerm));

            // Clear previous results
            searchResults.innerHTML = '';

            if (searchTerm && filteredPosts.length > 0) {
                searchResults.style.display = 'block';
                const ul = document.createElement('ul');

                filteredPosts.forEach(post => {
                    const li = document.createElement('li');
                    li.textContent = post.title.rendered;
                    li.setAttribute('data-title', post.title.rendered);
                    li.setAttribute('data-id', post.id);
                    li.addEventListener('click', function() {
                        searchInput.value = post.title.rendered;
                        hiddenInput.value = post.id;
                        searchResults.style.display = 'none';

                        // Update Elementor controls
                        const elementorEditor = window.elementor;
                        if (elementorEditor) {
                            const currentControl = elementorEditor.getPanelView().getCurrentPageView().model;
                            currentControl.setSetting('search_text', post.title.rendered);
                            currentControl.setSetting('search_id', post.id);
                        }

                        // Focus the input and trigger an input event to force update
                        searchInput.focus();
                        searchInput.value += ' '; // Add a space to trigger the input event
                        const event = new Event('input', { bubbles: true });
                        searchInput.dispatchEvent(event);
                    });
                    ul.appendChild(li);
                });

                searchResults.appendChild(ul);
            } else {
                searchResults.style.display = 'none';
            }
        });
    }
});