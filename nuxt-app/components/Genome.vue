<template>
  <section v-if="user" class="text-gray-300 ">
    <nav class="bg-gray-800 border-b border-black shadow-sm">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between">
          <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
            <div class="hidden sm:block sm:ml-6">
              <div class="flex space-x-4">
                <a href="#" class="relative inline-flex items-center px-3 py-2 rounded-full text-sm font-medium text-white hover:bg-gray-700 m-2" @click="back()">
                  <i class="block fas fa-arrow-left text-lg mx-1" />
                </a>
              </div>
            </div>
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-white text-2xl" v-text="user.person.name" />
            </div>
          </div>
        </div>
      </div>
    </nav>
    <div class="py-10 max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2">
        <div class="bg-gray-800 genome-column text-gray-100 mx-5">
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
        <div class="bg-gray-800 genome-column text-gray-100 mx-5 pb-5">
          <div class="w-full px-5 pt-5">
            <div class="grid grid-cols-4">
              <div class="text-center">
                <div class="block text-lg text-gray-400">
                  <i class="fas fa-eye" />
                </div>
                <div class="block text-3xl">
                  150k
                </div>
                <p class="text-xs font-sm text-gray-400">
                  views
                </p>
              </div>
              <div class="text-center">
                <div class="block text-lg text-gray-400">
                  <i class="fas fa-user-check" />
                </div>
                <div class="block text-3xl">
                  80k
                </div>
                <p class="text-xs font-sm text-gray-400">
                  signalers
                </p>
              </div>
              <div class="text-center">
                <div class="block text-lg text-gray-400">
                  <i class="fas fa-users" />
                </div>
                <div class="block text-3xl">
                  100k
                </div>
                <p class="text-xs font-sm text-gray-400">
                  connections
                </p>
              </div>
              <div class="text-center">
                <div class="block text-lg text-gray-400">
                  <i class="fas fa-weight-hanging" />
                </div>
                <div class="block text-3xl">
                  100k
                </div>
                <p class="text-xs font-sm text-gray-400">
                  recommendation weight
                </p>
              </div>
            </div>
          </div>
          <div class="w-full border-t border-gray-600 p-5 mt-5">
            <div class="grid grid-cols-2">
              <h3 class="text-xl">
                Signals
              </h3>
              <div class="text-right">
                <a class="relative inline-flex items-center px-3 py-2 rounded-full text-sm font-medium text-green hover:bg-gray-700 shadow-lg">
                  <i class="fas fa-share-alt text-2xl" />
                </a>
              </div>
            </div>
            <div class="flex flex-wrap justify-center text-center mb-10">
              <p class="px-5 pb-10">
                Let's <span v-text="user.person.name.split(' ')[0]" /> know you may consider working together:
              </p>
              <a class="cursor-pointer">
                <span class="p-3 pl-5 uppercase text-green font-sm bg-gray-700 shadow-lg rounded-l-full text-base">signaled</span>
                <span class="p-3 pr-5 uppercase text-green font-sm bg-gray-700 shadow-lg rounded-r-full text-base">
                  <i class="far fa-bell" />
                </span>
              </a>
            </div>
            <div class="grid grid-cols-2">
              <div class="text-center">
                <div class="block text-3xl">
                  <i class="fas fa-user-check" />
                  <span class="text-green"> 100,500</span>
                </div>
                <p class="text-sm font-sm">
                  people signaled <span v-text="user.person.name.split(' ')[0]" />
                </p>
              </div>
              <div class="text-center">
                <div class="block text-3xl">
                  <i class="fas fa-user-check" />
                  <span class="text-green"> 500</span>
                </div>
                <p class="text-sm font-sm">
                  people signaled by <span v-text="user.person.name.split(' ')[0]" />
                </p>
              </div>
            </div>
          </div>
          <div class="w-full border-t border-gray-600">
            <div class="text-center mb-5">
              <div class="text-left p-5">
                <h3 class="text-xl">
                  Community
                </h3>
              </div>
              <div class="flex flex-wrap justify-center">
                <p class="text-3xl w-full">
                  92,209
                </p>
                <p class="text-sm font-sm px-10 text-gray-400 w-6/12 mx-auto">
                  friends/colleagues connected
                </p>
              </div>
            </div>
          </div>
          <div class="w-full border-t border-gray-600 p-5">
            <div class="text-center mb-5">
              <p class="text-green text-xl">
                Time is over
              </p>
              <p class="px-5 pb-10">
                I need to stop investing time on the frontend. Hoping it's good enough. It's just abut time, the more the merrier.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  props: {
    username: {
      type: String,
      default: ''
    }
  },
  data: () => ({
    user: null,
    key: null,
    contador: 0,
    muestra: 0,
    stop: true,
    sampleFreq: 50
  }),
  mounted () {
    this.stop = false
    this.key = (new Date()).getTime()
    this.getUserInfo()
    const bodyElement = document.querySelector('body')
    bodyElement.classList.remove('bg-black')
    bodyElement.classList.add('bg-gray-800')
    const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)
    const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)
    onmousemove = (e) => {
      if (!this.stop) {
        this.contador++
      }
      const mod = (this.contador % this.sampleFreq)
      if (mod === (this.sampleFreq - 1)) {
        const params = {
          key: Number(this.key + this.muestra),
          username: this.username,
          x: e.clientX,
          y: e.clientY,
          vw,
          vh,
          op: 1
        }
        this.saveTrack(params)
        this.contador = 0
        this.muestra++
      }
    }
  },
  methods: {
    async getUserInfo () {
      const data = await this.$axios.$get(`http://164.90.146.112/getUserFromTorre/${this.username}`)
      this.user = data
    },
    async saveTrack (params) {
      await this.$axios.$post('https://2lvvmaeuo4.execute-api.us-east-2.amazonaws.com/prod/mousetracking', params)
    },
    getSourcer (text) {
      return text.replace('www.', '').substring(8, text.replace('www.', '').indexOf('.'))
    },
    back () {
      this.stop = true
      this.$emit('back')
    }
  }
}
</script>

<style scoped>
  .genome-column {
    position: relative;
    border-radius: 4px;
    -webkit-box-shadow: -2px -2px 6px #383b40, 6px 6px 6px rgb(0 0 0 / 24%);
    box-shadow: -2px -2px 6px #383b40, 6px 6px 6px rgb(0 0 0 / 24%);
  }
</style>
