<template>
  <Layout />
</template>

<script>
export default {
  mounted () {
    const bodyElement = document.querySelector('body')
    bodyElement.classList.add('h-screen')
    bodyElement.classList.add('bg-black')
  }
}
</script>
