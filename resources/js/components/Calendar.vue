<template>
  <v-app dark>
    <v-row class="fill-height">
      <v-col>
        <v-sheet height="64">
          <v-toolbar flat color="white">
            <v-btn class="mr-4" color="success darken-2" dark @click="showAddModal">
              <v-icon>mdi-plus-thick</v-icon>
            </v-btn>
            <v-btn class="mr-4" color="primary darken-2" @click="setToday">Today</v-btn>
            <v-btn fab text small color="grey darken-2" @click="prev">
              <v-icon small>mdi-chevron-left</v-icon>
            </v-btn>
            <v-btn fab text small color="grey darken-2" @click="next">
              <v-icon small>mdi-chevron-right</v-icon>
            </v-btn>
            <v-toolbar-title class="ml-4">{{ title }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu bottom right>
              <template v-slot:activator="{ on, attrs }">
                <v-btn color="primary darken-2" v-bind="attrs" v-on="on">
                  <span>{{ typeToLabel[type] }}</span>
                  <v-icon right>mdi-menu-down</v-icon>
                </v-btn>
              </template>
              <v-list>
                <v-list-item @click="type = 'day'">
                  <v-list-item-title>Day</v-list-item-title>
                </v-list-item>
                <v-list-item @click="type = 'week'">
                  <v-list-item-title>Week</v-list-item-title>
                </v-list-item>
                <v-list-item @click="type = 'month'">
                  <v-list-item-title>Month</v-list-item-title>
                </v-list-item>
                <v-list-item @click="type = '4day'">
                  <v-list-item-title>4 days</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
          </v-toolbar>
        </v-sheet>

        <v-sheet height="600">
          <v-calendar
            ref="calendar"
            v-model="focus"
            color="primary"
            :events="events"
            :event-color="getEventColor"
            :now="today"
            :type="type"
            @click:event="showEvent"
            @click:more="viewDay"
            @click:date="viewDay"
            @change="updateRange"
          ></v-calendar>
          <v-menu
            v-model="selectedOpen"
            :close-on-content-click="false"
            :activator="selectedElement"
            offset-x
            persistent
          >
            <v-card color="grey lighten-4" min-width="350px" flat>
              <!-- Toolbar for editmode -->
              <v-toolbar v-if="editmode" :color="event.color" dark>
                <v-toolbar-title v-html="event.name"></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon @click="deleteEvent(event.id)">
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </v-toolbar>
              <!-- Toolbar for addmode -->
              <v-toolbar v-else color="primary" dark>
                <v-toolbar-title>Add New Event</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <!-- Add event form component -->
                <EventForm :event="event" :errors="errors" :editmode="editmode" />
              </v-card-text>
              <v-card-actions>
                <v-btn text color="secondary" @click="selectedOpen = false">Cancel</v-btn>
                <v-btn v-if="editmode" text color="primary" @click.prevent="updateEvent(event)">Save</v-btn>
                <v-btn v-else text color="primary" @click.prevent="addEvent">Create</v-btn>
              </v-card-actions>
            </v-card>
          </v-menu>
        </v-sheet>
      </v-col>
    </v-row>
  </v-app>
</template>


<script>
import axios from "axios";
import moment from "moment";
import EventForm from "./EventForm";

export default {
  name: "Calendar",
  components: {
    EventForm
  },
  props: {
    user: Object
  },
  data: () => ({
    focus: new Date().toISOString().substr(0, 10), // Get current date, time is excluded
    today: new Date().toISOString().substr(0, 10), // Get current date, time is excluded
    type: "month", // Display month by default
    typeToLabel: {
      // available types of calendar view
      month: "Month",
      week: "Week",
      day: "Day",
      "4day": "4 Days"
    },
    // default values for adding, updating event
    event: {
      user: null,
      name: null,
      color: "#1976D2",
      start: null,
      end: null,
      room: null
    },
    start: null,
    end: null,
    selectedElement: null,
    selectedOpen: false,
    editmode: false,
    events: [], // all events
    // dialog: false, // show dialog
    errors: {}
  }),
  watch: {
    "event.start": function(val) {
      if (val) {
        this.event.start = moment(val).format("YYYY-MM-DD H:MM");
      }
    },
    "event.end": function(val) {
      if (val) {
        this.event.end = moment(val).format("YYYY-MM-DD H:MM");
      }
    }
  },
  computed: {
    // Calendar title, ordinal suffix
    title() {
      const { start, end } = this;
      if (!start || !end) {
        return "";
      }

      const startMonth = this.monthFormatter(start);
      const endMonth = this.monthFormatter(end);
      const suffixMonth = startMonth === endMonth ? "" : endMonth;

      const startYear = start.year;
      const endYear = end.year;
      const suffixYear = startYear === endYear ? "" : endYear;

      const startDay = start.day + this.nth(start.day);
      const endDay = end.day + this.nth(end.day);

      switch (this.type) {
        case "month":
          return `${startMonth} ${startYear}`;
        case "week":
        case "4day":
          return `${startMonth} ${startDay} ${startYear} - ${suffixMonth} ${endDay} ${suffixYear}`;
        case "day":
          return `${startMonth} ${startDay} ${startYear}`;
      }
      return "";
    },
    monthFormatter() {
      return this.$refs.calendar.getFormatter({
        timeZone: "UTC",
        month: "long"
      });
    }
  },
  mounted() {
    this.getEvents();
    // Authenticated user
    this.event.user = this.user;
  },
  methods: {
    // fetch events from the api
    async getEvents() {
      this.$Progress.start();
      await axios
        .get("api/events")
        .then(response => {
          this.events = response.data;
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    // redirects to the clicked day
    viewDay({ date }) {
      this.focus = date;
      this.type = "day";
    },
    // returns the color of each event
    getEventColor(e) {
      return e.color;
    },
    // set's the focus to the value of today
    setToday() {
      this.focus = this.today;
    },
    // previous, calendar api
    prev() {
      this.$refs.calendar.prev();
    },
    // next, calendar api
    next() {
      this.$refs.calendar.next();
    },
    showAddModal() {
      this.resetEvent();
      this.errors = {};
      this.editmode = false;
      this.selectedOpen = true;
    },
    // will show the clicked event
    showEvent({ nativeEvent, event }) {
      this.errors = {};
      this.editmode = true;
      // destructuring
      const open = () => {
        this.event = event; // set event to the current event
        this.selectedElement = nativeEvent.target; // selectedElement as the native javascript event (eg. HTMLDivElement)
        setTimeout(() => (this.selectedOpen = true), 10); // show popup with a delay of 10 milisecond
      };
      // show popup if selectedOpen is false and close if true
      if (this.selectedOpen) {
        this.selectedOpen = false;
        setTimeout(open, 10);
      } else {
        open();
      }
      nativeEvent.stopPropagation(); // prevent propagation
    },
    // add event
    async addEvent() {
      this.$Progress.start();
      await axios
        .post("api/events", this.event)
        .then(response => {
          this.events.push(response.data);
          this.selectedOpen = false;
          Toast.fire({
            icon: "success",
            title: "Event created successfully!"
          });
          this.$Progress.finish();
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          this.$Progress.fail();
        });
    },

    async updateEvent(event) {
      this.$Progress.start();
      await axios
        .put(`api/events/${event.id}`, event)
        .then(() => {
          this.getEvents();
          this.selectedOpen = false;
          Toast.fire({
            icon: "success",
            title: "Event updated successfully!"
          });
          this.$Progress.finish();
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          this.$Progress.fail();
        });
    },
    async deleteEvent(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          this.$Progress.start();
          axios
            .delete(`api/events/${id}`)
            .then(() => {
              this.getEvents();
              this.selectedOpen = false;
              Toast.fire({
                icon: "success",
                title: "Event deleted successfully!"
              });
              this.$Progress.finish();
            })
            .catch(() => {
              Toast.fire({
                icon: "error",
                title: "Something went wrong!"
              });
              this.$Progress.fail();
            });
        }
      });
    },
    resetEvent() {
      this.event = {
        user: this.user,
        name: null,
        color: "#1976D2",
        start: null,
        end: null,
        room: null
      };
    },
    // Return ordinal suffix of days
    updateRange({ start, end }) {
      this.start = start;
      this.end = end;
    },
    nth(d) {
      return d > 3 && d < 21
        ? "th"
        : ["th", "st", "nd", "rd", "th", "th", "th", "th", "th", "th"][d % 10];
    },
    rnd(a, b) {
      return Math.floor((b - a + 1) * Math.random()) + a;
    },
    formatDate(a, withTime) {
      return withTime
        ? `${a.getFullYear()}-${a.getMonth() +
            1}-${a.getDate()} ${a.getHours()}:${a.getMinutes()}`
        : `${a.getFullYear()}-${a.getMonth() + 1}-${a.getDate()}`;
    }
  }
};
</script>

