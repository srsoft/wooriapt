<template>
  <div>
    <UploadImages :max="4" @changed="handleImages"/>
  </div>
</template>

<script>
import UploadImages from "vue-upload-drop-images"

export default {
  layout: 'layoutTwitter',
  components: { UploadImages },
  data() {
    return {
      contents: '',
      search: '',
    }
  },
  methods: {
    handleImages(files){
      console.log(files)
      /*
        [
          {
              "name": "Screenshot from 2021-02-23 12-36-33.png",
              "size": 319775,
              "type": "image/png",
              "lastModified": 1614080193596
              ...
          },
          ...
          ]
       */
    }
  },
}
</script>


