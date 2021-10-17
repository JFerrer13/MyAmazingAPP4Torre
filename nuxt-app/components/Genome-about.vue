<template>
  <div v-if="user">
    <div class="w-full px-5 pt-5">
      <div class="-mt-10 text-center flex justify-center pb-2">
        <button type="button" class="bg-gray-800 flex text-sm rounded-full outline-none ring-4 ring-offset-1 ring-offset-gray-800 ring-gray-500 focus:ring-white" aria-expanded="false" aria-haspopup="true">
          <img class="h-32 w-32 rounded-full" :src="user ? user.person.picture : null" alt="">
        </button>
      </div>
      <div class="w-full">
        <h1 class="text-2xl text-left py-2" v-text="user.person.name" />
        <p class="py-2 text-sm" v-text="user.person.professionalHeadline" />
        <p class="py-2 pb-5 text-sm" v-text="user.person.location.shortName" />
      </div>
    </div>
    <div class="w-full px-5">
      <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px mb-5">
        <a v-for="(item,index) in user.person.links" :key="index" :href="item.address" class="relative inline-flex items-center px-3 py-2 rounded-full text-sm font-medium text-white hover:bg-gray-700" @click="getPeople(data.pagination.previous, null)">
          <i :class="'fab fa-' + getSourcer(item.address) + ' text-2xl pl-1'" />
        </a>
      </nav>
    </div>
    <div class="w-full border-t border-gray-600 p-5">
      <div>
        <h2 class="text-xl">
          <i class="fas fa-biking" /> Current skills:
        </h2>
        <div class="flex flex-wrap">
          <a v-for="(item, index) in user.strengths" :key="index" class="bg-gray-700 px-5 py-1 m-2 ml-0 rounded-full cursor-pointer">
            <span v-text="item.name" />
            <span v-if="item.weight">
              <i class="fas fa-weight-hanging" />
              <i v-text="Math.round(item.weight*10)/10" />
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      default: null
    }
  },
  methods: {
    getSourcer (text) {
      return text.replace('www.', '').substring(8, text.replace('www.', '').indexOf('.'))
    }
  }
}
</script>
