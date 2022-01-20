<template>
  <div
    class="container"
    @dragover.prevent="dragOver"
    @dragleave.prevent="dragLeave"
    @drop.prevent="drop($event)"
    v-show="Imgs.length > 0"
  >
    <div class="drop" v-show="dropped == 2"></div>
    <!-- Error Message -->
    <div v-show="error" class="error">
      {{ error }}
    </div>

    <!-- To inform user how to upload image -->
    <div v-show="Imgs.length == 0" class="beforeUpload">
      <input
        type="file"
        style="z-index: 1"
        accept="image/*"
        ref="uploadInput"
        @change="previewImgs"
        multiple
      />
    </div>
    <div :class="`imgsPreview count${Imgs.length}`" v-show="Imgs.length > 0">
      <div class="imageHolder" v-for="(img, i) in Imgs" :key="i">
        <img :src="img" />
        <span class="delete" @click="deleteImg(i)">
          <svg viewBox="0 0 24 24" aria-hidden="true"><g><path d="M13.414 12l5.793-5.793c.39-.39.39-1.023 0-1.414s-1.023-.39-1.414 0L12 10.586 6.207 4.793c-.39-.39-1.023-.39-1.414 0s-.39 1.023 0 1.414L10.586 12l-5.793 5.793c-.39.39-.39 1.023 0 1.414.195.195.45.293.707.293s.512-.098.707-.293L12 13.414l5.793 5.793c.195.195.45.293.707.293s.512-.098.707-.293c.39-.39.39-1.023 0-1.414L13.414 12z"></path></g></svg>
        </span>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "UploadImages", // vue component name
  data() {
    return {
      error: "",
      files: [],
      dropped: 0,
      Imgs: [],
    };
  },
  props: {
    max: Number,
    maxError: String,
    fileError: String,
  },
  methods: {
    imageInvoker() {
      this.append()
    },
    dragOver() {
      this.dropped = 2;
    },
    dragLeave() {},
    drop(e) {
      let status = true;
      let files = Array.from(e.dataTransfer.files)
      if (e && files) {
        files.forEach((file) => {
          if (file.type.startsWith("image") === false) status = false;
        });
        if (status == true) {
          if (
            this.$props.max &&
            files.length + this.files.length > this.$props.max
          ) {
            this.error = this.$props.maxError
              ? this.$props.maxError
              : `Maximum files is` + this.$props.max;
          } else {
            this.files.push(...files);
            this.previewImgs();
          }
        } else {
          this.error = this.$props.fileError
            ? this.$props.fileError
            : `Unsupported file type`;
        }
      }
      this.dropped = 0;
    },
    append() {
      this.$refs.uploadInput.click();
    },
    readAsDataURL(file) {
      return new Promise(function (resolve, reject) {
        let fr = new FileReader();
        fr.onload = function () {
          resolve(fr.result);
        };
        fr.onerror = function () {
          reject(fr);
        };
        fr.readAsDataURL(file);
      });
    },
    deleteImg(index) {
      this.Imgs.splice(index, 1);
      this.files.splice(index, 1);
      this.$emit("changed", this.files);
      this.$refs.uploadInput.value = null;
    },
    previewImgs(event) {
      if (
        this.$props.max &&
        event &&
        event.currentTarget.files.length + this.files.length > this.$props.max
      ) {
        this.error = this.$props.maxError
          ? this.$props.maxError
          : `Maximum files is` + this.$props.max;
        return;
      }
      if (this.dropped == 0) this.files.push(...event.currentTarget.files);
      this.error = "";
      this.$emit("changed", this.files);
      let readers = [];
      if (!this.files.length) return;
      for (let i = 0; i < this.files.length; i++) {
        readers.push(this.readAsDataURL(this.files[i]));
      }
      Promise.all(readers).then((values) => {
        this.Imgs = values;
      });
    },
    reset() {
      this.$refs.uploadInput.value = null;
      this.Imgs = [];
      this.files = [];
      this.$emit("changed", this.files);
    },
  },
};
</script>


<style lang="scss" scoped>
.container {
  width: 504px;
  height: 283px;
  position: relative;
  padding: 0px !important;
  overflow: hidden;
}

.drop {
  width: 100%;
  height: 100%;
  top: 0;
  border-radius: 10px;
  position: absolute;
  background-color: #f4f6ff;
  left: 0;
  border: 3px dashed #a3a8b1;
}

.error {
  text-align: center;
  color: red;
  font-size: 15px;
}

.beforeUpload {
  position: relative;
  text-align: center;

  input {
    width: 100%;
    margin: auto;
    height: 100%;
    opacity: 0;
    position: absolute;
    background: red;
    display: block;

    &:hover {
      cursor: pointer;
    }
  }

  .icon {
    width: 150px;
    margin: auto;
    display: block;
  }
}

.imgsPreview {
  &.count1 {
    .imageHolder {
      width: 504px;
      height: 283px;
    }
  }
  &.count2 {
    .imageHolder {
      width: 245px;
      height: 283px;
      &:first-child {
        margin-right: 12px;
      }
    }
  }
  &.count3 {
    .imageHolder {
      float: left;
      &:nth-child(1) {
        width: 245px;
        height: 283px;
        margin-right: 12px;
      }
      &:nth-child(2) {
        width: 245px;
        height: 135px;
        margin-bottom: 12px;
      }
      &:nth-child(3) {
        width: 245px;
        height: 135px;
      }
    }
  }
  &.count4 {
    .imageHolder {
      width: 245px;
      height: 135px;
      &:nth-child(1) {
        margin-right: 12px;
        margin-bottom: 12px;
      }
      &:nth-child(2) {
        margin-bottom: 12px;
      }
      &:nth-child(3) {
        margin-right: 12px;
      }
    }
  }
  .imageHolder {
    position: relative;
    display: inline-block;

    img {
      object-fit: cover;
      width: 100%;
      height: 100%;
      border-radius: 15px;
    }

    .delete {
      position: absolute;
      top: 4px;
      left: 4px;
      width: 32px;
      height: 32px;
      background-color: rgba(15, 20, 25, 0.75);
      border-radius: 999px;
      transition-duration: 0.2s;
      cursor: pointer;
      text-align: center;
      svg {
        width: 18px;
        height: 18px;
        fill: white;
        margin-top: 4px;
      }

    }
  }
}

.clearButton {
  color: #2d3748;
  position: absolute;
  top: 7px;
  right: 7px;
  background: none;
  border: none;
  cursor: pointer;
}
</style>
