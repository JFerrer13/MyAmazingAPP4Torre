<template>
  <div class="layout">
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
      <Data v-if="show == 'Data' " @back="back()" />
    </div>
  </div>
</template>
<script>

export default {
  data: () => ({
    tittle: 'Torre.co',
    current: 'Search',
    user: null,
    show: 'Search',
    username: ''
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
      const data = await this.$axios.$get(`https://torre.bio/api/bios/${user}`)
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
</style>
