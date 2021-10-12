<template>
  <section>
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
              <h1 class="text-white text-2xl" v-text="'Data analysis section'" />
            </div>
          </div>
        </div>
      </div>
    </nav>
    <div class="py-10 max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="grid grid-cols-3">
        <div class="mr-5">
          <div class="block flex flex-1 ">
            <select v-model="srchUser" class="cursor-pointer bg-gray-800 text-gray-300 form-select leading-snug w-full pl-5 pr-6 text-base placeholder-gray-400 border rounded-l-full appearance-none" @change="getData()">
              <option value="-1" readonly>
                Choose a user
              </option>
              <option v-for="(item,index) in users" :key="index" :value="item" v-text="item" />
            </select>
            <button class="p-2 pr-5 border uppercase text-green font-sm bg-gray-700 shadow-lg rounded-r-full text-base" @click="updUSers()">
              <i class="fas fa-sync mr-2" />
            </button>
          </div>
        </div>
        <div class="mr-5">
          <span class="text-gray-300 hidden">IP</span>
          <select class="cursor-pointer bg-gray-800 text-gray-300 form-select block w-full mt-1 h-10 pl-3 pr-6 text-base placeholder-gray-400 border rounded-lg appearance-none focus:shadow-outline hidden">
            <option value="-1" readonly>
              Choose a IP
            </option>
          </select>
        </div>
        <div class="text-right">
          <button class="bg-green text-gray px-6 py-2 uppercase rounded-full border-2 border-gray font-bold shadow-md  shadow-lg" @click="displayMAp()">
            <i class="fas fa-project-diagram mr-2" />
            display
          </button>
        </div>
      </div>
      <div class="w-full flex flex-wrap justify-center mt-10">
        <div v-if="vh !== 0 && vw !== 0" class="flex justify-center pb-5">
          <a class="cursor-pointer relative inline-flex items-center px-3 bg-gray-800 py-2 rounded-full text-sm font-medium text-white hover:bg-gray-700 mr-2" @click="clear()">
            <i :class="'fas fa-times pr-2'" /> Clear canvas
          </a>
          <a class="cursor-pointer relative inline-flex items-center px-3 bg-gray-800 py-2 rounded-full text-sm font-medium text-white hover:bg-gray-700" @click="play()">
            show data <i :class="'fas fa-play pl-2'" />
          </a>
        </div>
        <canvas class="w-full" :height="vh" :width="vw" :data-update="upd" />
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data: () => ({
    data: null,
    users: [],
    usrStats: null,
    srchUser: -1,
    vh: 0,
    vw: 0,
    upd: false,
    drawCanvas: false
  }),
  updated () {
    if (this.drawCanvas) {
      const canvas = document.querySelector('canvas')
      if (canvas) {
        const toShow = this.usrStats
        this.vh = toShow[0].vh
        this.vw = toShow[0].vw
        const baseImage = new Image(this.vw, this.vh)
        baseImage.src = '/prev.jpg'
        baseImage.addEventListener('load', (e) => {
          const context = canvas.getContext('2d')
          context.drawImage(baseImage, 0, 0, this.vw, this.vh)
          this.drawCanvas = false
        })
      } else {
        this.upd = !this.upd
      }
    }
  },
  mounted () {
    this.updUSers()
  },
  methods: {
    async getUsers () {
      const datos = await this.$axios.$get('http://164.90.146.112/getUsers')
      this.data = datos
      this.users = []
      for (let i = 0; i < this.data.length; i++) {
        const element = this.data[i]
        this.users.push(element.username)
      }
    },
    async getData () {
      if (Number(this.srchUser) === -1) {
        this.putAlert({
          title: 'Warning',
          text: 'Plase choose a user to display',
          color: 'yellow'
        })
        return -1
      }
      this.usrStats = []
      let datos = await this.$axios.$post('https://2lvvmaeuo4.execute-api.us-east-2.amazonaws.com/prod/mousetracking')
      if (!datos) {
        this.putAlert({
          title: 'Warning',
          text: 'Somthing wnt wrong while getting the inofmration',
          color: 'yellow'
        })
        return -1
      }
      datos = JSON.parse(datos.body)
      for (let i = 0; i < datos.length; i++) {
        const element = datos[i]
        const type = typeof element
        if (type !== 'undefined' && element.username === this.srchUser) {
          this.usrStats.push(element)
        }
      }
      this.clear()
    },
    async updUSers () {
      await this.$axios.$get('http://164.90.146.112/analyzeUsersData')
      this.getUsers()
      this.putAlert({
        title: 'Success',
        text: 'The user list has been updated',
        color: 'green'
      })
    },
    displayMAp () {
      if (Number(this.srchUser) === -1) {
        this.putAlert({
          title: 'Warning',
          text: 'Plase choose a user to display',
          color: 'yellow'
        })
        return -1
      }
      this.upd = !this.upd
      this.drawCanvas = true
    },
    play () {
      const canvas = document.querySelector('canvas')
      const context = canvas.getContext('2d')
      const toShow = this.usrStats
      toShow.forEach(function (circle) {
        const myGradient = context.createRadialGradient(circle.x, circle.y, 2, circle.x + 20, circle.y + 20, 40)
        myGradient.addColorStop(0, 'rgba(255, 0, 0, 0.5)')
        myGradient.addColorStop(1, 'rgba(255, 0, 0, 0)')
        context.beginPath()
        context.arc(circle.x, circle.y, 10, 0, Math.PI * 2)
        context.fillStyle = myGradient
        context.fill()
        context.strokeStyle = 'rgba(0, 0, 0, 0)'
        context.stroke()
      })
    },
    clear () {
      const canvas = document.querySelector('canvas')
      const context = canvas.getContext('2d')
      const baseImage = new Image()
      context.clearRect(0, 0, this.vw, this.vh)
      baseImage.src = '/prev.jpg'
      context.drawImage(baseImage, 0, 0, 0, 0)
      context.fill()
    },
    back () {
      this.stop = true
      this.$emit('back')
    },
    putAlert (element) {
      this.$emit('newalert', element)
    }
  }
}
</script>
