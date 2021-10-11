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
          <span class="text-gray-300">Users</span>
          <select v-model="srchUser" class="cursor-pointer bg-gray-800 text-gray-300 form-select block w-full mt-1 h-10 pl-3 pr-6 text-base placeholder-gray-400 border rounded-lg appearance-none focus:shadow-outline">
            <option value="-1" readonly>
              Choose a user
            </option>
            <option v-for="(item,index) in users" :key="index" :value="item" v-text="item" />
          </select>
        </div>
        <div class="mr-5">
          <span class="text-gray-300">Keys</span>
          <select v-model="srchKey" class="cursor-pointer bg-gray-800 text-gray-300 form-select block w-full mt-1 h-10 pl-3 pr-6 text-base placeholder-gray-400 border rounded-lg appearance-none focus:shadow-outline">
            <option value="-1" readonly>
              Choose a key
            </option>
            <option v-for="(item,index) in keys" :key="index" :value="item" v-text="item" />
          </select>
        </div>
        <div class="text-right">
          <button class="bg-green text-gray px-6 py-2 uppercase rounded-full border-2 border-gray font-bold shadow-md mt-3 shadow-lg" @click="displayMAp()">
            <i class="fas fa-project-diagram mr-2" />
            display
          </button>
        </div>
      </div>
      <div class="w-full flex flex-wrap justify-center mt-10">
        <div v-if="Object.keys(canvas).length !== 0" class="flex justify-center pb-5">
          <a class="cursor-pointer relative inline-flex items-center px-3 bg-gray-800 py-2 rounded-full text-sm font-medium text-white hover:bg-gray-700 mr-2" @click="play()">
            Play <i :class="'fas fa-play pl-2'" />
          </a>
          <a class="cursor-pointer relative inline-flex items-center px-3 bg-gray-800 py-2 rounded-full text-sm font-medium text-white hover:bg-gray-700" @click="clear()">
            Clear <i :class="'fas fa-times pl-2'" />
          </a>
        </div>
        <canvas class="w-full" :height="canvas.vh" :width="canvas.vw" :data-update="upd" />
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
    keys: [],
    keysStats: null,
    srchKey: -1,
    canvas: {},
    upd: false,
    drawCanvas: false
  }),
  updated () {
    if (this.drawCanvas) {
      const canvas = document.querySelector('canvas')
      if (canvas) {
        const user = this.srchUser
        const toShow = this.usrStats[user]
        this.canvas.vh = toShow[0].vh
        this.canvas.vw = toShow[0].vw
        const context = canvas.getContext('2d')
        const baseImage = new Image()
        baseImage.src = '/prev.jpg'
        context.drawImage(baseImage, 0, 0, toShow[0].vw, toShow[0].vh)
        this.drawCanvas = false
        context.fill()
      } else {
        this.upd = !this.upd
      }
    }
  },
  mounted () {
    this.getData()
  },
  methods: {
    async getData () {
      let datos = await this.$axios.$post('https://2lvvmaeuo4.execute-api.us-east-2.amazonaws.com/prod/mousetracking')
      datos = JSON.parse(datos.body)
      this.data = datos
      const usrTemp = {}
      const kyTemp = {}
      for (let i = 0; i < this.data.length; i++) {
        const element = this.data[i]
        kyTemp[element.key] = !kyTemp[element.key] ? 1 : kyTemp[element.key] + 1
        if (usrTemp[element.username] !== undefined) {
          usrTemp[element.username].push(element)
        } else {
          usrTemp[element.username] = []
          usrTemp[element.username].push(element)
        }
      }
      this.users = Object.keys(usrTemp)
      this.usrStats = usrTemp
      this.keys = Object.keys(kyTemp)
      this.keysStats = kyTemp
    },
    displayMAp () {
      if (Number(this.srchUser) === -1 && Number(this.srchKey === -1)) {
        return -1
      }
      this.upd = !this.upd
      this.drawCanvas = true
    },
    play () {
      const canvas = document.querySelector('canvas')
      const context = canvas.getContext('2d')
      const user = this.srchUser
      const toShow = this.usrStats[user]
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
    back () {
      this.stop = true
      this.$emit('back')
    }
  }
}
</script>
