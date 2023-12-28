// dashboard.js

const { createApp } = Vue;

// Define your chart component
const ChartComponent = {
  props: ['data'],
  template: `<div>Chart Component: {{ data }}</div>`,
};

// Define your table component
const TableComponent = {
  props: ['data'],
  template: `<div>Table Component: {{ data }}</div>`,
};

createApp({
  data() {
    return {
      chartData: [], // Sample data for the chart component
      tableData: [], // Sample data for the table component
    };
  },
  components: {
    'chart-component': ChartComponent,
    'table-component': TableComponent,
  },
}).mount('#dashboard');
