<template>
  <section>
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
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-white text-2xl" v-text="'Data analysis section'" />
            </div>
          </div>
        </div>
      </div>
    </nav>
    <div class="py-10 max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="pb-7 text-gray-400">
        Please choose a user to show the analyzed data.
      </div>
      <div class="grid grid-cols-3">
        <div class="mr-5">
          <div class="block flex flex-1 ">
            <select v-model="srchUser" class="cursor-pointer bg-gray-800 text-gray-300 form-select leading-snug w-full pl-5 pr-6 text-base placeholder-gray-400 border rounded-full appearance-none py-2" @change="getData()">
              <option value="-1" readonly>
                Choose a user
              </option>
              <option v-for="(item,index) in users" :key="index" :value="item" v-text="item" />
            </select>
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
          <a class="hidden cursor-pointer relative inline-flex items-center px-3 bg-gray-800 py-2 rounded-full text-sm font-medium text-white hover:bg-gray-700" @click="play()">
            show data <i :class="'fas fa-play pl-2'" />
          </a>
        </div>
        <div v-if="vh !== 0 && vw !== 0" class="grid grid-cols-2 w-full">
          <span class="text-xs text-gray-400">Lower</span>
          <span class="text-xs text-gray-400 text-right">Higher</span>
          <div class="col-span-2 p-3 my-2 heat-gradient w-full" />
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
    drawCanvas: false,
    heatmapPressition: 64,
    grid: null
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
          const maxValue = this.tempfunc()
          if (!this.gridDrawn) {
            const hight = Math.trunc(this.vh / this.heatmapPressition)
            const width = Math.trunc(this.vw / this.heatmapPressition)
            for (let yAxis = 0; yAxis < this.grid.length; yAxis++) {
              for (let xAxis = 0; xAxis < this.grid[yAxis].length; xAxis++) {
                const yPsition = Math.trunc(yAxis * this.vh / this.heatmapPressition)
                const xPsition = Math.trunc(xAxis * this.vw / this.heatmapPressition)
                context.fillRect(xPsition, yPsition, width, hight)
                context.fillStyle = this.getColor(this.grid[yAxis][xAxis], maxValue)
                context.fill()
              }
            }
          }
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
        this.pushAlert({
          title: 'Warning',
          text: 'Plase choose a user to display',
          color: 'yellow'
        })
        return -1
      }
      this.usrStats = []
      let datos = await this.$axios.$post('https://2lvvmaeuo4.execute-api.us-east-2.amazonaws.com/prod/mousetracking')
      if (!datos) {
        this.pushAlert({
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
      this.pushAlert({
        title: 'Success',
        text: 'The user list has been updated',
        color: 'green'
      })
    },
    displayMAp () {
      if (Number(this.srchUser) === -1) {
        this.pushAlert({
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
    pushAlert (element) {
      this.$emit('newalert', element)
    },
    tempfunc () {
      if (!this.vw) {
        return -1
      }
      const grid = new Array(this.heatmapPressition)
      let maxValue = 0
      for (let i = 0; i < this.heatmapPressition; i++) {
        grid[i] = new Array(this.heatmapPressition).fill(0)
      }
      for (let i = 0; i < this.usrStats.length; i++) {
        const x = this.getCoordinate(this.usrStats[i].x, 'x')
        const y = this.getCoordinate(this.usrStats[i].y, 'y')
        grid[y][x]++
        if (grid[y][x] > maxValue) {
          maxValue = grid[y][x]
        }
      }
      this.grid = grid
      return maxValue
    },
    getCoordinate (value, axis) {
      const viewportLength = axis === 'x' ? this.vw : this.vh
      for (let i = 0; i < this.heatmapPressition - 1; i++) {
        const lowerLimit = Math.trunc((viewportLength * i) / this.heatmapPressition)
        const upperLimit = Math.trunc((viewportLength * (i + 1)) / this.heatmapPressition)
        if (value >= lowerLimit && value < upperLimit) {
          return i
        }
      }
    },
    getColor (value, maxValue) {
      let lowerLimit = 0
      let upperLimit = 0
      const colors = ['rgba(69, 13, 84, 0.1)', 'rgba(68, 58, 131, 0.3)', 'rgba(48, 104, 142, 0.4)', 'rgba(34, 144, 140, 0.4)', 'rgba(53, 183, 121, 0.5)', 'rgba(143, 215, 68, 0.5)', 'rgba(253, 231, 37, 0.6)']
      if (maxValue > 8) {
        maxValue = 7
      }
      for (let i = 0; i < colors.length - 1; i++) {
        if (maxValue < 7) {
          lowerLimit = i
          upperLimit = i + 1
        } else {
          lowerLimit = Math.trunc((maxValue * i) / colors.length)
          upperLimit = Math.trunc((maxValue * (i + 1)) / colors.length)
        }
        if (value >= lowerLimit && value < upperLimit) {
          return colors[i]
        }
      }
    }
  }
}
</script>

<style scoped>
  .heat-gradient{
    background: rgb(69,13,84);
    background: linear-gradient(90deg, rgba(69,13,84,1) 0%, rgba(68,58,84,1) 16%, rgba(48,104,142,1) 34%, rgba(34,144,140,1) 52%, rgba(53,183,121,1) 68%, rgba(143,215,68,1) 86%, rgba(253,231,37,1) 100%);
  }
</style>
