<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import Link from '@tiptap/extension-link'
import {
  Bold, Italic, List, ListOrdered, Heading2, Heading3,
  Link as LinkIcon, Image as ImageIcon, Undo, Redo
} from 'lucide-vue-next'
import { watch } from 'vue'

const props = defineProps({
  modelValue: String,
  placeholder: String,
})

const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
  content: props.modelValue,
  extensions: [
    StarterKit,
    Image,
    Link.configure({
      openOnClick: false,
    }),
  ],
  onUpdate: ({ editor }) => {
    emit('update:modelValue', editor.getHTML())
  },
})

watch(() => props.modelValue, (value) => {
  if (editor.value && value !== editor.value.getHTML()) {
    editor.value.commands.setContent(value)
  }
})

const addImage = () => {
  const url = prompt('URL de l\'image :')
  if (url) {
    editor.value.chain().focus().setImage({ src: url }).run()
  }
}

const addLink = () => {
  const url = prompt('URL du lien :')
  if (url) {
    editor.value.chain().focus().setLink({ href: url }).run()
  }
}
</script>

<template>
  <div class="border border-gray-300 rounded-lg overflow-hidden">
    <!-- Toolbar -->
    <div class="bg-gray-50 border-b border-gray-300 p-2 flex flex-wrap gap-1">
      <button
        @click="editor.chain().focus().toggleBold().run()"
        :class="{ 'bg-primary-100': editor?.isActive('bold') }"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Gras"
      >
        <Bold :size="18" />
      </button>
      <button
        @click="editor.chain().focus().toggleItalic().run()"
        :class="{ 'bg-primary-100': editor?.isActive('italic') }"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Italique"
      >
        <Italic :size="18" />
      </button>

      <div class="w-px bg-gray-300 mx-1" />

      <button
        @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
        :class="{ 'bg-primary-100': editor?.isActive('heading', { level: 2 }) }"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Titre 2"
      >
        <Heading2 :size="18" />
      </button>
      <button
        @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
        :class="{ 'bg-primary-100': editor?.isActive('heading', { level: 3 }) }"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Titre 3"
      >
        <Heading3 :size="18" />
      </button>

      <div class="w-px bg-gray-300 mx-1" />

      <button
        @click="editor.chain().focus().toggleBulletList().run()"
        :class="{ 'bg-primary-100': editor?.isActive('bulletList') }"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Liste à puces"
      >
        <List :size="18" />
      </button>
      <button
        @click="editor.chain().focus().toggleOrderedList().run()"
        :class="{ 'bg-primary-100': editor?.isActive('orderedList') }"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Liste numérotée"
      >
        <ListOrdered :size="18" />
      </button>

      <div class="w-px bg-gray-300 mx-1" />

      <button
        @click="addLink"
        :class="{ 'bg-primary-100': editor?.isActive('link') }"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Ajouter un lien"
      >
        <LinkIcon :size="18" />
      </button>
      <button
        @click="addImage"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Ajouter une image"
      >
        <ImageIcon :size="18" />
      </button>

      <div class="w-px bg-gray-300 mx-1" />

      <button
        @click="editor.chain().focus().undo().run()"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Annuler"
      >
        <Undo :size="18" />
      </button>
      <button
        @click="editor.chain().focus().redo().run()"
        type="button"
        class="p-2 hover:bg-gray-200 rounded transition"
        title="Refaire"
      >
        <Redo :size="18" />
      </button>
    </div>

    <!-- Editor -->
    <EditorContent
      :editor="editor"
      class="prose max-w-none p-4 min-h-[300px] focus:outline-none"
    />
  </div>
</template>

<style>
.ProseMirror {
  outline: none;
}

.ProseMirror h2 {
  font-size: 1.5rem;
  font-weight: bold;
  margin-top: 1.5rem;
  margin-bottom: 1rem;
}

.ProseMirror h3 {
  font-size: 1.25rem;
  font-weight: bold;
  margin-top: 1.25rem;
  margin-bottom: 0.75rem;
}

.ProseMirror p {
  margin-bottom: 1rem;
}

.ProseMirror ul, .ProseMirror ol {
  margin-left: 1.5rem;
  margin-bottom: 1rem;
}

.ProseMirror ul {
  list-style-type: disc;
}

.ProseMirror ol {
  list-style-type: decimal;
}

.ProseMirror a {
  color: #00A651;
  text-decoration: underline;
}

.ProseMirror img {
  max-width: 100%;
  height: auto;
  border-radius: 0.5rem;
  margin: 1rem 0;
}
</style>
