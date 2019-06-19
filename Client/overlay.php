<style>
.taste-overlay {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
}
.taste-container {
    width: 80%;
    height: 80%;
    margin: auto;
    background: #fff;
    padding: 50px;
    box-sizing: border-box;
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
    background-color: #000000;
    color: #fff;
}
.taste-item {
    font-size: 1.1em;
    width: 80%;
    margin: auto;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    height: 80%;
}
.item-title {
    font-family: 'Rubik', sans-serif;
    padding: 10px;
}
.item-option {
    font-size: 0.9em;
    padding: 5px;
}
.item-option.clicked {
    background: red;
}
#next {
    padding: 10px;
    box-sizing: border-box;
    background: #2196f3;
    border: none;
    color: #fff;
  }
#next:hover {
    background: linear-gradient(#2196f3, #1976d2);   
}
.taste {
    display: none;
}
.radio-container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.radio-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}
.radio-container:hover input ~ .checkmark {
  background-color: #ccc;
}
.radio-container input:checked ~ .checkmark {
  background-color: #2196F3;
}
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}
.radio-container input:checked ~ .checkmark:after {
  display: block;
}
.radio-container .checkmark:after {
  top: 9px;
  left: 9px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}
</style>

<div class="taste-overlay" id="tasteOverlay">
    <div class="taste-container" id="tasteContainer">
        <span class="taste-item">
            <div class="item-title" id="itemTitle">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam beatae laborum, sunt totam doloribus error accusantium reiciendis iure voluptate quasi?
            </div>
            <label class="radio-container">
                <span class="item-option"></span>
                <input type="radio" name="option">
                <span class="checkmark"></span>
            </label>
            <label class="radio-container">
                <span class="item-option"></span>
                <input type="radio" name="option">
                <span class="checkmark"></span>
            </label>
            <label class="radio-container">
                <span class="item-option"></span>
                <input type="radio" name="option">
                <span class="checkmark"></span>
            </label>
            <label class="radio-container">
                <span class="item-option"></span>
                <input type="radio" name="option">
                <span class="checkmark"></span>
            </label>
            <button id="next">Next</button>
        </div>
    </div>
</div>