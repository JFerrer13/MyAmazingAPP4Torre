<template>
  <div class="layout static">
    <nav class="bg-gray-800 border-b border-gray-600">
      <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between">
          <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-white text-2xl">
                torre
              </h1>
            </div>
          </div>
          <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
            <div class="hidden sm:block sm:ml-6">
              <div class="flex space-x-4">
                <a href="https://possible-drawer-6c0.notion.site/My-Amazing-APP-for-Torre-ed86b39f878449e0aec4e5d230acbca9" class="w-16 text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 text-xs font-sm text-center" target="_blank">
                  <i class="block fas fa-book text-lg" />
                  About
                </a>
                <a class="cursor-pointer w-16 text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 text-xs font-sm text-center" @click="show='Search'">
                  <i class="block fas fa-user-friends text-lg" />
                  Search
                </a>
                <a class="cursor-pointer w-16 text-gray-300 hover:bg-gray-900 hover:text-white px-3 py-2 text-xs font-sm text-center" @click="show='Data'">
                  <i class="block fas fa-database text-lg" />
                  Data
                </a>
              </div>
            </div>
            <div class="ml-3 relative">
              <div>
                <button type="button" class="bg-gray-800 flex text-sm rounded-full outline-none ring-2 ring-offset-1 ring-offset-gray-800 ring-gray-500 focus:ring-white" aria-expanded="false" aria-haspopup="true" @click="openTorre()">
                  <img class="h-10 w-10 rounded-full" :src="user ? user.person.picture : null" alt="">
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <div class="">
      <Search v-if="show == 'Search'" @sendUsername="gotoUser($event)" />
      <Genome v-if="show == 'User'" :username="username" @back="back()" />
      <Data v-if="show == 'Data' " @back="back()" @newalert="pushAlert($event)" />
    </div>
    <div v-if="alerts" class="transition duration-700 absolute p-5 top-32 right-0">
      <div v-for="(item, index) in alerts" :key="index" :class="'fade-in bg-opacity-90 shadow-lg w-80 pb-5 bg-' + item.color + '-100 border-l-4 border-' + item.color + '-500 text-' + item.color + '-700 p-4 mb-3'" role="alert">
        <div class="inline-block animate-pulse hover:animate-none w-10/12">
          <p class="font-bold" v-text="item.title" />
          <p v-text="item.text" />
        </div>
        <span class="inline-block w-1/12" @click="closeAlert(index)">
          <svg :class="'fill-current h-6 w-6 text-' + item.colot + '-500'" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <title>Close</title>
            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
          </svg>
        </span>
      </div>
    </div>
    <div class="hidden transition duration-700 absolute p-5 top-32 right-0 inline-block animate-pulse hover:animate-none w-10/12 fade-in bg-opacity-90 shadow-lg w-80 pb-5 border-l-4  bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 bg-green-100 border-l-4 border-green-500 text-green-700" />
    <div class="hidden text-blue-100 text-blue-200 text-blue-300 text-blue-400 text-blue-500 text-blue-600 text-blue-700 text-gray-200 text-gray-300 text-gray-100 bg-red-600 bg-yellow-600 bg-green-300 bg-yellow-300 bg-green-600 bg-blue-600 bg-indigo-600 bg-purple-600 bg-pink-600" />
  </div>
</template>
<script>

export default {
  data: () => ({
    tittle: 'Torre.co',
    current: 'Search',
    user: null,
    show: 'Search',
    username: '',
    alerts: []
  }),
  mounted () {
    const queryString = window.location.search
    const urlParams = new URLSearchParams(queryString)
    const user = urlParams.get('user')
    if (user) {
      this.getUser(user)
    } else {
      this.getUser('13ferrer')
    }
  },
  methods: {
    async getUser (user) {
      const data = await this.$axios.$get(`http://164.90.146.112/getUserFromTorre/${user}`)
      this.user = data
    },
    openTorre () {
      window.open('https://torre.co', '_blank')
    },
    gotoUser (e) {
      this.show = 'User'
      this.username = e
    },
    back () {
      this.show = 'Search'
    },
    pushAlert (element) {
      if (this.alerts.length > 3) {
        this.alerts.shift()
      }
      this.alerts.push(element)
    },
    closeAlert (i) {
      this.alerts.splice(i, 1)
    }
  }
}
</script>

<style>
  .bg-green{
    background-color: #cddc39;
  }
  .text-green{
    color: #cddc39;
  }
  .text-gray{
    color: #27292d;
  }
  .border-gray{
    border-color: #27292d;
  }
  .img-adj{
    width: 64px;
    height: 64px;
    max-width: none;
  }
  .hover\:animate-none:hover{
    animation: none;
  }
  .fade-in {
    animation: fadein 1s;
    -moz-animation: fadein 1s; /* Firefox */
    -webkit-animation: fadein 1s; /* Safari and Chrome */
    -o-animation: fadein 1s; /* Opera */
  }
  @keyframes fadein {
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
  }
  @-moz-keyframes fadein { /* Firefox */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
  }
  @-webkit-keyframes fadein { /* Safari and Chrome */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
  }
  @-o-keyframes fadein { /* Opera */
    from {
        opacity:0;
    }
    to {
        opacity: 1;
    }
  }
</style>
