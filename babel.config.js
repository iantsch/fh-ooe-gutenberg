const presets = [
  ["@babel/preset-env", {
    forceAllTransforms: true,
    useBuiltIns: "entry",
    corejs: 2
  }]
];

const plugins = [
  ["transform-react-jsx", {
    pragma: "wp.element.createElement"
  }]
];

module.exports = {presets, plugins};