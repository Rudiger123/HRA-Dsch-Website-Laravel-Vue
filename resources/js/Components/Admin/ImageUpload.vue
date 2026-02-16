<script setup>
import { ref } from 'vue'
import { Upload, X, Image as ImageIcon } from 'lucide-vue-next'

const props = defineProps({
  modelValue: [String, File],
  currentImage: String,
  label: String,
  required: Boolean,
  error: String
})

const emit = defineEmits(['update:modelValue'])

const preview = ref(props.currentImage || null)
const fileInput = ref(null)

const handleFileChange = (event) => {
  const file = event.target.files[0]
  if (file) {
    emit('update:modelValue', file)

    // Preview
    const reader = new FileReader()
    reader.onload = (e) => {
      preview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const removeImage = () => {
  preview.value = null
  emit('update:modelValue', null)
  if (fileInput.value) {
    fileInput.value.value = ''
  }
}

const triggerUpload = () => {
  fileInput.value?.click()
}
</script>

<template>
  <div>
    <label v-if="label" class="block text-sm font-semibold text-gray-700 mb-2">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>

    <div class="relative">
      <!-- Preview ou zone upload -->
      <div
        v-if="preview"
        class="relative w-full h-48 rounded-lg overflow-hidden border-2 border-gray-300 group"
      >
        <img
          :src="preview"
          alt="Preview"
          class="w-full h-full object-cover"
        />
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition flex items-center justify-center">
          <button
            type="button"
            @click="removeImage"
            class="opacity-0 group-hover:opacity-100 transition bg-red-600 text-white p-3 rounded-full hover:bg-red-700"
          >
            <X :size="20" />
          </button>
        </div>
      </div>

      <div
        v-else
        @click="triggerUpload"
        class="w-full h-48 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-primary-500 hover:bg-primary-50 transition"
      >
        <Upload :size="40" class="text-gray-400 mb-2" />
        <p class="text-sm text-gray-600 mb-1">Cliquez pour uploader une image</p>
        <p class="text-xs text-gray-500">PNG, JPG jusqu'à 2MB</p>
      </div>

      <input
        ref="fileInput"
        type="file"
        accept="image/jpeg,image/jpg,image/png"
        @change="handleFileChange"
        class="hidden"
      />
    </div>

    <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
  </div>
</template>
