<template>
  <div class="w-full relative">
    <div class="relative rounded-full border border-gray-400 px-6 py-2">
      <div class="flex">
        <div class="min-w-24 min-h-24">
          <span class="text-gray-400 text-xl">
            <i class="fas fa-user" />
          </span>
        </div>
        <input
          v-model="searchTern"
          class="w-full text-gray-200 bg-transparent px-5 focus-visible:border-0 focus-visible:outline-none focus:outline-none focus-visible:border-0 pr-0"
          type="text"
          @keyup.enter="onEnter"
        >
      </div>
      <label class="absolute title w-full top-0 left-0">
        <span class="absolute left-0 ml-5 text-gray-400 bg-black -mt-3 px-1" v-text="caption" />
      </label>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    caption: {
      type: String,
      default: 'Search'
    }
  },
  data: () => ({
    searchTern: ''
  }),
  methods: {
    go () {
      this.$emit('search', this.searchTern)
    },
    onEnter () {
      this.go()
    }
  }
}
</script>

<style scoped>
.title {
  pointer-events: auto;
  top: -1px;
  font-size: 12px;
}
</style>
