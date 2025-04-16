<template>
    <div class="border border-gray-200 rounded-lg overflow-hidden">
        <!-- Toolbar -->
        <div v-if="editor"
            class="flex flex-wrap items-center gap-1 p-2 border-b border-gray-200 bg-gray-50 sticky top-0 z-10">
            <!-- Text Formatting Group -->
            <div class="flex items-center border-r border-gray-200 pr-1 mr-1">
                <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive('bold') ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path>
                        <path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path>
                    </svg>
                </button>
                <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive('italic') ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Italic">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="4" x2="10" y2="4"></line>
                        <line x1="14" y1="20" x2="5" y2="20"></line>
                        <line x1="15" y1="4" x2="9" y2="20"></line>
                    </svg>
                </button>
                <button type="button" @click="editor.chain().focus().toggleUnderline().run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive('underline') ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 3v7a6 6 0 0 0 6 6 6 6 0 0 0 6-6V3"></path>
                        <line x1="4" y1="21" x2="20" y2="21"></line>
                    </svg>
                </button>
                <button type="button" @click="editor.chain().focus().toggleStrike().run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive('strike') ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Strikethrough">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <path d="M16 6c-.5-1.8-2.1-3-4-3s-3.5 1.2-4 3"></path>
                        <path d="M16 18c-.5 1.8-2.1 3-4 3s-3.5-1.2-4-3"></path>
                    </svg>
                </button>
            </div>

            <!-- Headings Group -->
            <div class="flex items-center border-r border-gray-200 pr-1 mr-1">
                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors font-bold',
                    editor.isActive('heading', { level: 1 }) ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Heading 1">
                    H1
                </button>
                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors font-bold',
                    editor.isActive('heading', { level: 2 }) ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Heading 2">
                    H2
                </button>
                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors font-bold',
                    editor.isActive('heading', { level: 3 }) ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Heading 3">
                    H3
                </button>
            </div>

            <!-- Text Alignment Group -->
            <div class="flex items-center border-r border-gray-200 pr-1 mr-1">
                <button type="button" @click="editor.chain().focus().setTextAlign('left').run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive({ textAlign: 'left' }) ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Align Left">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="15" y2="12"></line>
                        <line x1="3" y1="18" x2="18" y2="18"></line>
                    </svg>
                </button>
                <button type="button" @click="editor.chain().focus().setTextAlign('center').run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive({ textAlign: 'center' }) ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Align Center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="6" y1="12" x2="18" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <button type="button" @click="editor.chain().focus().setTextAlign('right').run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive({ textAlign: 'right' }) ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Align Right">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="9" y1="12" x2="21" y2="12"></line>
                        <line x1="6" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Lists Group -->
            <div class="flex items-center border-r border-gray-200 pr-1 mr-1">
                <button type="button" @click="editor.chain().focus().toggleBulletList().run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive('bulletList') ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Bullet List">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="8" y1="6" x2="21" y2="6"></line>
                        <line x1="8" y1="12" x2="21" y2="12"></line>
                        <line x1="8" y1="18" x2="21" y2="18"></line>
                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                    </svg>
                </button>
                <button type="button" @click="editor.chain().focus().toggleOrderedList().run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive('orderedList') ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Numbered List">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="10" y1="6" x2="21" y2="6"></line>
                        <line x1="10" y1="12" x2="21" y2="12"></line>
                        <line x1="10" y1="18" x2="21" y2="18"></line>
                        <path d="M4 6h1v4"></path>
                        <path d="M4 10h2"></path>
                        <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"></path>
                    </svg>
                </button>
            </div>

            <!-- Special Elements Group -->
            <div class="flex items-center border-r border-gray-200 pr-1 mr-1">
                <button type="button" @click="editor.chain().focus().toggleCodeBlock().run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive('codeBlock') ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Code Block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6"></polyline>
                        <polyline points="8 6 2 12 8 18"></polyline>
                    </svg>
                </button>
                <button type="button" @click="editor.chain().focus().toggleBlockquote().run()" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive('blockquote') ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Blockquote">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z">
                        </path>
                        <path
                            d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z">
                        </path>
                    </svg>
                </button>
                <button type="button" @click="editor.chain().focus().setHorizontalRule().run()"
                    class="p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors" title="Horizontal Rule">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
            </div>

            <!-- Media Group -->
            <div class="flex items-center border-r border-gray-200 pr-1 mr-1">
                <button type="button" @click="setLink" :class="[
                    'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                    editor.isActive('link') ? 'bg-gray-200 text-blue-600' : ''
                ]" title="Insert Link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                </button>
                <button type="button" @click="addImage"
                    class="p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors" title="Insert Image">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                </button>
                <button type="button" @click="addYoutubeVideo"
                    class="p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors"
                    title="Insert YouTube Video">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                        </path>
                        <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                    </svg>
                </button>
            </div>

            <!-- Undo/Redo Group -->
            <div class="flex items-center">
                <button type="button" @click="editor.chain().focus().undo().run()" :disabled="!editor.can().undo()"
                    :class="[
                        'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                        !editor.can().undo() ? 'opacity-50 cursor-not-allowed' : ''
                    ]" title="Undo">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 10h10a4 4 0 0 1 0 8H5a4 4 0 0 1 0-8h1"></path>
                        <polyline points="7 10 3 6 7 2"></polyline>
                    </svg>
                </button>
                <button type="button" @click="editor.chain().focus().redo().run()" :disabled="!editor.can().redo()"
                    :class="[
                        'p-1.5 rounded text-gray-700 hover:bg-gray-200 transition-colors',
                        !editor.can().redo() ? 'opacity-50 cursor-not-allowed' : ''
                    ]" title="Redo">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10H11a4 4 0 0 0 0 8h8a4 4 0 0 0 0-8h1"></path>
                        <polyline points="17 10 21 6 17 2"></polyline>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Bubble Menu (appears when selecting text) -->
        <bubble-menu class="flex bg-white p-1 shadow-lg rounded-md border border-gray-200 z-50"
            :tippy-options="{ duration: 100 }" :editor="editor" v-if="editor">
            <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="[
                'px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 rounded',
                editor.isActive('bold') ? 'bg-gray-100 text-blue-600' : ''
            ]">
                Bold
            </button>
            <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="[
                'px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 rounded',
                editor.isActive('italic') ? 'bg-gray-100 text-blue-600' : ''
            ]">
                Italic
            </button>
            <button type="button" @click="editor.chain().focus().toggleUnderline().run()" :class="[
                'px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 rounded',
                editor.isActive('underline') ? 'bg-gray-100 text-blue-600' : ''
            ]">
                Underline
            </button>
            <button type="button" @click="setLink" :class="[
                'px-2 py-1 text-sm text-gray-700 hover:bg-gray-100 rounded',
                editor.isActive('link') ? 'bg-gray-100 text-blue-600' : ''
            ]">
                Link
            </button>
        </bubble-menu>

        <!-- Editor Content -->
        <editor-content :editor="editor" class="min-h-[300px] p-4 outline-none" />
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import { Editor, EditorContent, BubbleMenu } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Link from '@tiptap/extension-link'
import Image from '@tiptap/extension-image'
import Youtube from '@tiptap/extension-youtube'
import TextAlign from '@tiptap/extension-text-align'
import axios from 'axios'

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])

const editor = ref(null)

// Watch for external changes to modelValue
watch(() => props.modelValue, (newValue) => {
    // Only update content if editor exists and content is different
    if (editor.value && newValue !== editor.value.getHTML()) {
        editor.value.commands.setContent(newValue, false)
    }
}, { immediate: true })

onMounted(() => {
    editor.value = new Editor({
        content: props.modelValue,
        extensions: [
            StarterKit,
            Underline,
            Link.configure({
                openOnClick: false,
                HTMLAttributes: {
                    class: 'text-blue-500 hover:underline',
                    rel: 'noopener noreferrer',
                    target: '_blank',
                },
            }),
            Image.configure({
                HTMLAttributes: {
                    class: 'rounded-lg max-w-full h-auto my-4',
                },
                allowBase64: true,
            }),
            Youtube.configure({
                inline: false,
                HTMLAttributes: {
                    class: 'rounded-lg my-4',
                },
            }),
            TextAlign.configure({
                types: ['heading', 'paragraph'],
                defaultAlignment: 'left',
            }),
        ],
        onUpdate: ({ editor }) => {
            emit('update:modelValue', editor.getHTML())
        },
        editorProps: {
            attributes: {
                class: 'prose prose-sm sm:prose lg:prose-lg xl:prose-xl mx-auto focus:outline-none',
            },
        },
    })
})

onBeforeUnmount(() => {
    editor.value?.destroy()
})

// Methods
const setLink = () => {
    const previousUrl = editor.value.getAttributes('link').href
    const url = window.prompt('URL', previousUrl)

    if (url === null) return

    if (url === '') {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run()
        return
    }

    // Add http:// prefix if not present
    const formattedUrl = url.match(/^https?:\/\//) ? url : `http://${url}`

    editor.value
        .chain()
        .focus()
        .extendMarkRange('link')
        .setLink({ href: formattedUrl })
        .run()
}

// const addImage = async () => {
//     const input = document.createElement('input')
//     input.type = 'file'
//     input.accept = 'image/*'

//     input.onchange = async () => {
//         if (input.files?.length) {
//             const file = input.files[0]

//             try {
//                 // Create a temporary placeholder
//                 const placeholderId = `image-${Date.now()}`

//                 // Create a temporary URL for preview
//                 const tempUrl = URL.createObjectURL(file)
//                 editor.value.commands.setImage({
//                     src: tempUrl,
//                     'data-placeholder': placeholderId,
//                     alt: file.name,
//                 })

//                 // Upload the image
//                 const formData = new FormData()
//                 formData.append('image', file)

//                 try {
//                     const { data } = await axios.post('/api/upload-image', formData, {
//                         headers: {
//                             'Content-Type': 'multipart/form-data',
//                         },
//                     })

//                     // Replace placeholder with actual image
//                     const tr = editor.value.state.tr
//                     const doc = editor.value.state.doc
//                     let found = false

//                     doc.descendants((node, pos) => {
//                         if (found) return false
//                         if (node.type.name === 'image' && node.attrs['data-placeholder'] === placeholderId) {
//                             tr.setNodeMarkup(pos, undefined, {
//                                 ...node.attrs,
//                                 src: data.url,
//                                 alt: file.name,
//                                 'data-placeholder': undefined,
//                             })
//                             found = true
//                             return false
//                         }
//                     })

//                     if (found) {
//                         editor.value.view.dispatch(tr)
//                     }
//                 } catch (error) {
//                     console.error('Image upload error:', error)
//                     // Keep the local image if upload fails
//                     // You could show a warning to the user here
//                 }
//             } catch (error) {
//                 console.error('Error handling image:', error)
//             }
//         }
//     }

//     input.click()
// }

const addImage = async () => {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    
    input.onchange = async () => {
        if (!input.files?.length) return;
        
        const file = input.files[0];
        const tempUrl = URL.createObjectURL(file);
        
        try {
            // 1. Insert temporary image
            editor.value.commands.setImage({
                src: tempUrl,
                alt: file.name,
                'data-status': 'uploading'
            });

            // 2. Upload to server
            const formData = new FormData();
            formData.append('image', file);
            
            const { data } = await axios.post('/api/articles/upload-image', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });

            // 3. Replace with permanent URL
            editor.value.commands.updateAttributes('image', {
                src: data.url,
                'data-status': 'uploaded'
            });

            // 4. Clean up blob URL
            URL.revokeObjectURL(tempUrl);

        } catch (error) {
            console.error('Upload failed:', error);
            // Mark as failed or remove the image
            editor.value.commands.updateAttributes('image', {
                'data-status': 'failed',
                src: '/images/upload-failed.jpg'
            });
        }
    };

    input.click();
};



const addYoutubeVideo = () => {
    const url = prompt('Enter YouTube URL:')

    if (url) {
        // Extract YouTube ID if needed
        let youtubeId = url
        const match = url.match(/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/)

        if (match && match[1]) {
            youtubeId = match[1]
        }

        editor.value.commands.setYoutubeVideo({
            src: youtubeId,
            width: 640,
            height: 480,
        })
    }
}
</script>

<style>
/* ProseMirror specific styles */
.ProseMirror {
    @apply min-h-[300px] outline-none;
}

.ProseMirror:focus {
    @apply outline-none;
}

.ProseMirror p {
    @apply mb-4;
}

.ProseMirror h1 {
    @apply text-3xl font-bold mb-4 mt-6;
}

.ProseMirror h2 {
    @apply text-2xl font-bold mb-3 mt-5;
}

.ProseMirror h3 {
    @apply text-xl font-bold mb-3 mt-4;
}

.ProseMirror ul {
    @apply list-disc pl-5 mb-4;
}

.ProseMirror ol {
    @apply list-decimal pl-5 mb-4;
}

.ProseMirror blockquote {
    @apply border-l-4 border-gray-300 pl-4 italic my-4 text-gray-700;
}

.ProseMirror code {
    @apply font-mono bg-gray-100 px-1 py-0.5 rounded text-sm;
}

.ProseMirror pre {
    @apply bg-gray-800 text-white p-4 rounded-lg my-4 overflow-x-auto;
}

.ProseMirror pre code {
    @apply bg-transparent text-white p-0;
}

.ProseMirror img {
    @apply max-w-full h-auto rounded-lg shadow-sm;
}

.ProseMirror img.ProseMirror-selectednode {
    @apply outline-2 outline-blue-500 outline;
}

.ProseMirror .iframe-wrapper {
    @apply relative pb-[56.25%] h-0 overflow-hidden my-4;
}

.ProseMirror iframe {
    @apply absolute top-0 left-0 w-full h-full border-0;
}

.ProseMirror .text-align-left {
    @apply text-left;
}

.ProseMirror .text-align-center {
    @apply text-center;
}

.ProseMirror .text-align-right {
    @apply text-right;
}

.ProseMirror hr {
    @apply my-6 border-t border-gray-300;
}

.ProseMirror a {
    @apply text-blue-600 hover:underline;
}
</style>