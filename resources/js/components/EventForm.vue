<template>
  <v-form>
    <v-text-field
      v-model="event.name"
      :error-messages="errors.name"
      type="text"
      label="Event"
      required
      autocomplete="off"
    ></v-text-field>

    <v-datetime-picker
      v-model="event.start"
      label="Start"
      :text-field-props="textFieldProps"
      :date-picker-props="dateProps"
      :time-picker-props="timeProps"
    >
      <template slot="dateIcon">
        <v-icon>mdi-calendar-month</v-icon>
      </template>
      <template slot="timeIcon">
        <v-icon>mdi-clock-time-nine-outline</v-icon>
      </template>
      <template slot="actions" slot-scope="{ parent }">
        <v-btn color="primary darken-1" @click="parent.okHandler">Done</v-btn>
      </template>
    </v-datetime-picker>
    <div>
      <small v-if="errors.start" class="text-danger">{{ errors.start[0] }}</small>
    </div>

    <v-datetime-picker
      v-model="event.end"
      label="End"
      :text-field-props="textFieldProps"
      :date-picker-props="dateProps"
      :time-picker-props="timeProps"
    >
      <template slot="dateIcon">
        <v-icon>mdi-calendar-month</v-icon>
      </template>
      <template slot="timeIcon">
        <v-icon>mdi-clock-time-nine-outline</v-icon>
      </template>
      <template slot="actions" slot-scope="{ parent }">
        <v-btn color="primary darken-1" @click="parent.okHandler">Done</v-btn>
      </template>
    </v-datetime-picker>
    <div>
      <small v-if="errors.end" class="text-danger">{{ errors.end[0] }}</small>
    </div>

    <v-text-field
      v-model="event.room"
      :error-messages="errors.room"
      type="text"
      label="Room"
      required
      autocomplete="off"
    ></v-text-field>

    <v-text-field
      v-model="event.color"
      :error-messages="errors.color"
      type="color"
      label="Color"
      required
    ></v-text-field>
  </v-form>
</template>

<script>
export default {
  name: "EventForm",
  props: {
    event: Object,
    errors: Object,
    editmode: Boolean,
  },
  data() {
    return {
      textFieldProps: {
        appendIcon: "mdi-calendar-range"
      },
      dateProps: {
        headerColor: "primary"
      },
      timeProps: {
        headerColor: "success",
        useSeconds: false,
        ampmInTitle: true
      }
    };
  },
};
</script>

<style>
</style>
