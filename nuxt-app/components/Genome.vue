<template>
  <section class="text-gray-300" :data-screenshot="needScreenshot">
    <nav class="bg-gray-800 border-b border-black shadow-sm">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between">
          <div class="flex-1 flex items-stretch justify-start">
            <div class="block">
              <div class="flex space-x-4">
                <a href="#" class="relative inline-flex items-center px-3 py-2 rounded-full text-sm font-medium text-white hover:bg-gray-700 m-2 ml-0" @click="back()">
                  <i class="block fas fa-arrow-left text-lg mx-1" />
                </a>
              </div>
            </div>
            <div v-if="user" class="flex-shrink-0 flex items-center">
              <h1 class="text-white text-2xl" v-text="user.person.name" />
            </div>
            <div v-else class="flex-shrink-0 flex items-center">
              <h1 class="text-gray-3400 text-2xl" v-text="'Loading ...'" />
            </div>
          </div>
        </div>
        <div class="relative block md:hidden">
          <div class="grid grid-cols-2">
            <div class="pt-3 border-b-2 border-gray-800 text-center" @click="setTab('about')">
              <span :class="tab == 'about' ? 'text-green' : ''">About</span>
              <hr v-if="tab == 'about'" class="border border-green mt-3">
              <hr v-else class="border border-gray-800 mt-3">
            </div>
            <div class="pt-3 border-b-2 border-gray-800 text-center" @click="setTab('reputation')">
              <span :class="tab == 'reputation' ? 'text-green' : ''">Reputation</span>
              <hr v-if="tab == 'reputation'" class="border border-green mt-3">
              <hr v-else class="border border-gray-800 mt-3">
            </div>
          </div>
        </div>
      </div>
    </nav>
    <div v-if="user" class="py-10 max-w-7xl mx-auto lg:px-8">
      <div class="grid grid-cols-2 hidden md:grid lg:grid">
        <div class="bg-gray-800 genome-column text-gray-100">
          <Genome-about :user="user" />
        </div>
        <div class="bg-gray-800 genome-column text-gray-100 ml-14 pb-5">
          <Genome-reputation :user="user" />
        </div>
      </div>
      <div class="grid sm:block md:hidden">
        <div v-if="tab == 'about'">
          <div class="bg-gray-800 genome-column text-gray-100">
            <Genome-about :user="user" />
          </div>
        </div>
        <div v-else-if="tab == 'reputation'">
          <div class="bg-gray-800 genome-column text-gray-100 pb-5">
            <Genome-reputation :user="user" />
          </div>
        </div>
      </div>
    </div>
    <div v-else class="text-gray-200 text-3xl text-center py-16">
      <i class="fas fa-circle-notch animate-spin" />
    </div>
  </section>
</template>
<script>
import html2canvas from 'html2canvas'
import GenomeAbout from './Genome-about.vue'

export default {
  components: { GenomeAbout },
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
    sampleFreq: 100,
    tab: 'about',
    needScreenshot: false
  }),
  updated () {
    if (this.user) {
      this.$nextTick(() => {
        if (this.needScreenshot) {
          this.$nextTick(() => {
            this.takeScreenshot()
          })
        }
      })
    }
  },
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
          key: this.key + '|' + this.muestra,
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
      this.needScreenshot = true
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
    back () {
      this.stop = true
      this.$emit('back')
    },
    setTab (value) {
      this.tab = value
      this.key = (new Date()).getTime()
      this.needScreenshot = true
    },
    async takeScreenshot () {
      const dataURL = await html2canvas(document.body).then((canvas) => {
        return canvas.toDataURL()
      })
      const params = {
        user: this.username,
        key: this.key,
        img: dataURL,
        tab: this.tab
      }
      await this.$axios.$post('http://164.90.146.112/SaveImage/', params).catch(() => {
        this.pushAlert({
          title: 'Ups!',
          text: 'There was an error saving screenshot',
          color: 'yellow'
        })
      })
    },
    pushAlert (element) {
      this.$emit('newalert', element)
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
