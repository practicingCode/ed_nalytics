<!--
    Dashboard
     - SEO Checklist
     - Top 4 Visualizations
-->

<!DOCTYPE html>
<html lang="en">
<head>
  <title>eD_Nalytics</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<style>
$lavendar: #7B64A4;
$indigo: #535ADF;
$blue: #DCEEFF;
$white: #FFFFFF;
$orange: #F2994A;

$lavendar-1: lighten($lavendar, 40);
$lavendar-2: lighten($lavendar, 20);
$lavendar-3: $lavendar;
$lavendar-4: darken($lavendar, 20);
$lavendar-5: darken($lavendar, 40);

$border-radius-l: 16px;
$border-radius-m: 6px;

$border: 1px solid $lavendar-1;

$font-size-l: 1.375rem;
$font-size-m: 1rem;
$font-size-s: .75rem;
$icon-size: 1.375rem;

$font-weight-fat: 700;
$icon-weight-fat: 900;

$link: $lavendar-3;
$link-visited: $lavendar-4;
$link-hover: $indigo;
$link-active: $indigo;

$progress-bg: $lavendar-1;
$progress-value: $indigo;

$button-bg: $lavendar-1;
$button-bg-hover: $indigo;
$button-bg-active: $indigo;
$button-color-hover: $white;
$button-color-active: $white;

$time-bg-read: $lavendar-2;
$time-bg-watch: $indigo;
$time-font-size: $font-size-s;

$card-bg-article: $lavendar-1;
$card-color-article: $lavendar-4;
$card-bg-chat: $lavendar-1;
$card-color-chat: $lavendar-3;
$card-bg-video: $indigo;
$card-color-video: $white;
$card-border-radius: $border-radius-l;

$summary-color: $lavendar-3;
$dashboard-title-color: $lavendar-4;
$dashboard-link-color: $indigo;
$teacher-color: $lavendar-5;
$teacher-focus-color: $indigo;

$base-font-family: 'Lato', sans-serif;
$base-font-color: $lavendar-5;
$base-font-size: $font-size-m;
$layout-padding: .75rem 1.25rem;

$bp-s: 56.25em;
$bp-m: 60em;

html {
  background-color: $blue;
  font-family: $base-font-family;
  font-size: $base-font-size;
  padding: 2.5rem;
}

body {
  background-color: $white;
  border-radius: $border-radius-l;
  display: grid;
  grid-template-columns: 1fr;
  grid-template-areas: "logo" "nav" "header" "aside" "main";
  
  @media (min-width: $bp-s) {
    grid-template-areas: 
      "logo header"
      "nav main"
      "aside main";
    grid-template-columns: 1fr 3fr;
  }
}

.c-logo {
  border-right: $border;
  border-bottom: $border;
  grid-area: logo;
  padding: $layout-padding;
  
  .l-logo {
    display: flex;
    align-items: center;

    &::before {
      margin-right: .5rem;
    }
  }

  .ui-logo {
    font-size: $font-size-l;

    &::before {
      color: $orange;
      content: "\f185";
      font-family: "Font Awesome 5 Free";
      font-size: $icon-size;
      font-weight: $icon-weight-fat;
    }
  } 
  
  input {
    display: block;
    width: 40px;
    height: 32px;
    position: absolute;
    top: -7px;
    left: -5px;

    cursor: pointer;

    opacity: 0; /* hide this */
    z-index: 2; /* and place it over the hamburger */

    -webkit-touch-callout: none;
  }
  
  span {
    display: block;
    width: 33px;
    height: 4px;
    margin-bottom: 5px;
    position: relative;

    background: #cdcdcd;
    border-radius: 3px;

    z-index: 1;

    transform-origin: 4px 0px;

    transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
                background 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
                opacity 0.55s ease;
  }
  
  span:first-child {
    transform-origin: 0% 0%;
  }
  
  span:nth-last-child(2) {
    transform-origin: 0% 100%;
  }
  
  input:checked ~ span {
    opacity: 1;
    transform: rotate(45deg) translate(-2px, -1px);
    background: #232323;
  }
  
  input:checked ~ span:nth-last-child(3) {
    opacity: 0;
    transform: rotate(0deg) scale(0.2, 0.2);
  }
  
  input:checked ~ span:nth-last-child(2) {
    transform: rotate(-45deg) translate(0, -1px);
  }
}

#nav
{
  position: absolute;
  width: 300px;
  margin: -100px 0 0 -50px;
  padding: 50px;
  padding-top: 125px;
  
  background: #ededed;
  list-style-type: none;
  -webkit-font-smoothing: antialiased;
  /* to stop flickering of text in safari */
  
  transform-origin: 0% 0%;
  transform: translate(-100%, 0);
  
  transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0);
}

.l-header {
  border-bottom: $border;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: $layout-padding;
  grid-area: header;
}

.l-nav {
  border-right: $border;
  border-bottom: $border;
  padding: $layout-padding;
  grid-area: nav;
  
  ul {
    margin: .5rem 0;
  }
  
  li {
    padding: .75rem 0;
  }
}

.ui-nav {
  a {
    text-decoration: none;
    
    &:link {
      color: $link;
    }
    
    &:visited {
      color: $link-visited;
    }
    
    &:hover {
      color: $link-hover;
    }
    
    &:active {
      color: $link-active;
    }
  }
}
  
.l-summary {
  border-right: $border;
  padding: $layout-padding;
  grid-area: aside;
  
  > header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: .5rem 0;
  }
  
  ul {
    margin: .5rem 0;
  }
  
  li {
    padding: .75rem 0;
    display: flex;
    flex-direction: column;
  }
  
  progress {
    border: 0;
    height: .25rem;
    margin: .5rem 0;
  }
  
  footer {
    display: flex;
    justify-content: space-between;
  }
}

.ui-summary {
  color: $summary-color;
  
  progress {
    background-color: $progress-bg;
    appearance: none;
    
    &::-moz-progress-bar,
    &::-webkit-progress-value {
      background-color: $progress-value;
    }
  }
  
  footer {
    font-size: $font-size-s;
  }
}

.l-dashboard {
  grid-area: main;
  padding: 2.5rem 2rem;
  display: inline-grid;
  grid-template-areas: "tags" "articles" "chats" "videos" "teachers";
  grid-template-columns: 1fr;
  
  @media (min-width: $bp-s) {
    grid-template-areas: "tags tags" "articles chats" "videos teachers";
    grid-template-columns: 2fr 1fr;
    grid-gap: 2.5rem;
  }
  
  > section {
    margin-top: 2rem;
    
    > header {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }
  }
}

.ui-dashboard {
  > section {
    > header {
      color: $dashboard-title-color;
      font-size: $font-size-l;
      
      a {
        color: $dashboard-link-color;
        font-weight: $font-weight-fat;
        text-decoration: none;
      }
    }
  }
}

.l-articles {
  grid-area: articles;

  > div {
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 1rem;
    
    @media (min-width: $bp-s) {
      grid-template-columns: 2fr 1fr;
    }
  }
}

.l-chats {
  grid-area: chats;

  > div {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 1rem;
    
    @media (min-width: $bp-s) {
      grid-template-rows: repeat(2, auto);
      grid-template-columns: repeat(2, auto);
    }
  }
}

.l-videos {
  grid-area: videos;

  > div {
    display: grid;
    grid-template-columns: 1fr;
    grid-template-areas: "first" "second" "third";
    grid-gap: 1rem;
    
    @media (min-width: $bp-s) {
      grid-template-rows: repeat(2, 1fr);
      grid-template-columns: 2fr 1fr;
      grid-template-areas: "first second" "first third";
    }
  }
}

.l-teachers {
  grid-area: teachers;

  > header {
    justify-content: space-between;
  }

  li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: .75rem 0;
  }

  .l-description {
    flex: 1 1 auto;
    margin: 0 .75rem;

    & p:last-child {
      margin-top: .25rem;
    }
  }
}

.ui-teachers {
  font-size: $base-font-size;
  
  .ui-grade {
    color: $teacher-focus-color;
  }

  .ui-description {
    & p:last-child {
      color: lighten(desaturate($teacher-color, 50), 40);
    }
  }
}

.c-search {
  flex: 1 1 auto;
}

.c-user {
  color: $base-font-color;
  font-size: $base-font-size;
  text-decoration: none;
  flex: 0 0 auto;
  display: flex;
  align-items: center;
  margin-left: .5rem;

  > img {
    margin-right: .25rem;
  }
}

.c-button {
  border: 0;
  font-size: $base-font-size;
  
  &.l-button--icon {
    flex: 0 0 auto;
    font-size: $icon-size;
  }
  
  &.ui-button--icon {
    background: none;
    color: $base-font-color;
  }
  
  &.l-button--nav {
    padding-right: 0;
  }
  
  &.ui-button--nav {
    background: transparent;
    color: $link;
    
    &:hover,
    &:active {
      color: $link-active;
    }
  }
  
  &.l-button--primary {
    margin: .25rem;
    padding: .25rem .5rem;

  }
  
  &.ui-button--primary {
    border-radius: $border-radius-m;
    background-color: $button-bg;
    // font-size: $font-size-s;
    
    &:hover,
    &:focus {
      background-color: $button-bg-active;
      color: $button-color-active;
    }
  }
}

.c-button-group {
  margin: -.25rem;
  grid-area: tags;
}

.c-link--withIcon {
  display: flex;
  align-items: center;

  .fas {
    font-size: $icon-size;
    flex: 0 0 1.125rem;
    display: flex;
    justify-content: center;
    margin-right: 1rem;
  }
}

.c-card {
  padding: 1rem;
  border-radius: $card-border-radius;
  
  > img {
    height: auto;
    width: 100%;
  }
  
  > footer {
    display: flex;
    justify-content: space-between;
    
    img {
      margin-right: .5rem;
      flex: 0 0 auto;
    }
    
    > div {
      line-height: 1.25;
      flex: 1 1 auto;
    }
    
    address {
      color: inherit;
    }
    
    time {
      flex: 0 0 auto;
    }
  }
  
  &.l-card--article {
    grid-template-areas: "heading heading" "time image" "footer footer";
    grid-template-columns: 1fr 1fr;
    grid-template-rows: max-content auto max-content;
    grid-gap: 1rem;
    display: grid;
    
    .heading {
      grid-area: heading;
    }
    
    time {
      grid-area: time;
      align-self: start;
      justify-self: start;
      margin-top: 1rem;
    }
    
    > img {
      grid-area: image;
      align-self: end;
    }
    
    footer {
      grid-area: footer;
    }
  }
  
  &.ui-card--article {
    background-color: $card-bg-article;
    color: $card-color-article;
  }
  
  &.l-card--chat {
    footer {
      justify-content: center;
      margin-top: .5rem;
      grid-area: footer;
    }
  }
  
  &.ui-card--chat {
    background-color: $card-bg-chat;
    color: $card-color-chat;
  }
  
  &.l-card--video {
    display: grid;
    grid-template-rows: max-content max-content;
    grid-template-areas: "heading" "credit";
    grid-gap: 1rem;
    align-content: space-between;
    
    .heading {
      grid-area: heading;
    }
    
    time {
      grid-area: time;
      align-self: start;
      justify-self: end;
    }
    
    &:first-of-type {
      grid-area: first;
    }
  }
  
  &.ui-card--video {
    background-color: $card-bg-video;
    color: $card-color-video;
    
    span {
      color: fade-out($white, .6);
    }
  }
}

.font {
  &-s {
    font-size: .75rem;
  }
  
  &-m {
    font-size: 1rem;
  }
  
  &-l {
    font-size: 1.25rem;
  }
}

img {
  &.circle {
    border-radius: 50%;
  }
  
  &.circle--s {
    height: 1.5rem;
    width: 1.5rem;
  }
  
  &.circle--l {
    height: 3rem;
    width: 3rem;
  }
  
  &.square {
    border-radius: 6px;
  }
  
  &.square-m {
    height: 2rem;
    width: 2rem;
  }
}

time {
  border-radius: $border-radius-m;
  color: inherit;
  font-size: $time-font-size;
  padding: .25rem .5rem;
  
  &.toRead {
    background-color: fade-out($time-bg-read, .7);
    
    &::before {
      content: "\f017";
      font-family: "Font Awesome 5 Free"; 
      font-weight: $icon-weight-fat;
      margin-right: .25rem;
    }
  }
  
  &.toWatch {
    background-color: darken($time-bg-watch, 10);
  }
}
</style>
<div class="c-logo">
  <h1 class="l-logo ui-logo">LearningLight</h1>
  <input type="checkbox">
  <span></span>
  <span></span>
  <span></span>
</div>

<header class="l-header">
  <div class="c-search">
    <i class="fas fa-search"></i>
    <input type="text" placeholder="Search">
  </div>

  <div class="c-user">
    <button class="c-button l-button--icon ui-button--icon">
      <i class="fas fa-bell"></i>
    </button>

    <button class="profile">
      <img class="circle circle--s" src="https://images.generated.photos/TeIvnowajO-bAz50Fw0hRvIjJd3-qNEqgVI1r_OBcm4/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zL3Yy/XzAyNDg5NTQuanBn.jpg" alt="Rosemary Stewart">
      Debra Cooper
    </button>
  </div>
</header>

<nav class="l-nav ui-nav" id="nav">
  <ul>
    <li>
      <a href="#" class="c-link--withIcon">
        <i class="fas fa-home"></i>
        Home
      </a>
    </li>
    <li>
      <a href="#" class="c-link--withIcon">
        <i class="fas fa-graduation-cap"></i>
        Courses
      </a>
    </li>
    <li>
      <a href="#" class="c-link--withIcon">
        <i class="fas fa-lightbulb"></i>
        Training
      </a>
    </li>
    <li>
      <a href="#" class="c-link--withIcon">
        <i class="fas fa-chart-pie"></i>
        Statistics
      </a>
    </li>
    <li>
      <a href="#" class="c-link--withIcon">
        <i class="fas fa-cog"></i>
        Settings
      </a>
    </li>
  </ul>
</nav>

<aside class="l-summary ui-summary">
  <header>
    <h3 class="c-link--withIcon">
      <i class="fas fa-book"></i>
      Homework
    </h3>

    <button class="c-button l-button--nav ui-button--nav">
      <i class="fas fa-arrow-right"></i>
    </button>
  </header>
  
  <ul>
    <li>
      <label for="basicsOfComposition">Basics of Composition</label>
      <progress id="basicsOfComposition" max="5" value="4">80%</progress>
      <footer>
        <span aria-label="Assignments completed">4 / 5</span>
        <output name="percent" for="basicsOfComposition">80%</output>
      </footer>
    </li>
    <li>
      <label for="typographyBasics">Typography Basics</label>
      <progress id="typographyBasics" max="5" value="3">60%</progress>
      <footer>
        <span aria-label="Assignments completed">3 / 5</span>
        <output name="percent" for="typographyBasics">60%</output>
      </footer>
    </li>
    <li>
      <label for="colorBasics">Color Basics</label>
      <progress id="colorBasics" max="5" value="2">40%</progress>
      <footer>
        <span aria-label="Assignments completed">2 / 5</span>
        <output name="percent" for="colorBasics">40%</output>
      </footer>
    </li>
    <li>
      <label for="modularMesh">Modular Mesh</label>
      <progress id="modularMesh" max="5" value="3">60%</progress>
      <footer>
        <span aria-label="Assignments completed">3 / 5</span>
        <output name="percent" for="modularMesh">60%</output>
      </footer>
    </li>
  </ul>
</aside>

<main class="l-dashboard ui-dashboard">
  <div class="c-button-group">
    <button class="c-button l-button--primary ui-button--primary">English</button>
    <button class="c-button l-button--primary ui-button--primary">Product</button>
    <button class="c-button l-button--primary ui-button--primary">UX/UI Design</button>
    <button class="c-button l-button--primary ui-button--primary">Time Management</button>
    <button class="c-button l-button--primary ui-button--primary">Development</button>
    <button class="c-button l-button--primary ui-button--primary">Graphic Design</button>
    <button class="c-button l-button--primary ui-button--primary">History of England</button>
  </div>
  
  <section class="l-articles ui-articles">
    <header>
      <h2>Articles <a href="#">162</a></h2>
    </header>
    
    <div>
      <article class="c-card l-card--article ui-card--article">
        <h3 class="font-l">Inclusive Design Principles</h3>
        <time class="toRead">5 min</time>
        <img src="http://placeimg.com/200/200/tech/grayscale" alt="dummy image">
        <footer>
          <img class="square square-m" src="https://images.generated.photos/TeIvnowajO-bAz50Fw0hRvIjJd3-qNEqgVI1r_OBcm4/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zL3Yy/XzAyNDg5NTQuanBn.jpg" alt="Rosemary Stewart">
          <div class="font-s">
            <address>Rosemary Stewart</address>
            <date>Feb 11</date>
          </div>
        </footer>
      </article>
      
      <article class="c-card l-card--article ui-card--article">
        <h3 class="font-l">Design Trends in 2020</h3>
        <time class="toRead">1 min</time>
        <img src="http://placeimg.com/200/200/tech/grayscale" alt="dummy image">
        <footer>
          <img class="square square-m" src="https://images.generated.photos/TeIvnowajO-bAz50Fw0hRvIjJd3-qNEqgVI1r_OBcm4/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zL3Yy/XzAyNDg5NTQuanBn.jpg" alt="Rosemary Stewart">
          <div class="font-s">
            <address>Bessie Bell</address>
            <date>Feb 4</date>
          </div>
        </footer>
      </article>
    </div>
  </section>
  
  <section class="l-chats">
    <header>
      <h2>Theme Chats <a href="#">24</a></h2>
    </header>
    <div>
      <article class="c-card l-card--chat ui-card--chat">
        <img src="http://placeimg.com/200/200/tech/grayscale" alt="dummy image">
        <footer>
          <h3 class="font-s">Education</h3>
        </footer>
      </article>
      
      <article class="c-card l-card--chat ui-card--chat">
        <img src="http://placeimg.com/200/200/tech/grayscale" alt="dummy image">
        <footer>
          <h3 class="font-s">Work</h3>
        </footer>
      </article>
      
      <article class="c-card l-card--chat ui-card--chat">
        <img src="http://placeimg.com/200/200/tech/grayscale" alt="dummy image">
        <footer>
          <h3 class="font-s">University</h3>
        </footer>
      </article>
      
      <article class="c-card l-card--chat ui-card--chat">
        <img src="http://placeimg.com/200/200/tech/grayscale" alt="dummy image">
        <footer>
          <h3 class="font-s">Technology</h3>
        </footer>
      </article>
    </div>
  </section>
  
  <section class="l-videos">
    <header>
      <h2>Video Lessons <a href="#">124</a></h2>
    </header>
    <div>
      <article class="c-card l-card--video ui-card--video">
        <h3 class="font-l">We create effective texts for landing.</h3>
        <footer>
          <img class="square square-m" src="https://images.generated.photos/TeIvnowajO-bAz50Fw0hRvIjJd3-qNEqgVI1r_OBcm4/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zL3Yy/XzAyNDg5NTQuanBn.jpg" alt="Rosemary Stewart">
          <div class="font-s">
            <address>Randall McCoy</address>
            <span>CEO, California Tech.</span>
          </div>
          <time class="toWatch">10:08</time>
        </footer>
      </article>
      
      <article class="c-card l-card--video ui-card--video">
        <h3 class="font-m">We make a website card thing. Training.</h3>
        <footer>
          <img class="square square-m" src="https://images.generated.photos/TeIvnowajO-bAz50Fw0hRvIjJd3-qNEqgVI1r_OBcm4/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zL3Yy/XzAyNDg5NTQuanBn.jpg" alt="Rosemary Stewart">
          <div class="font-s">
            <address>Jorge Murphy</address>
            <span>Senior Designer</span>
          </div>
        </footer>
      </article>
      
      <article class="c-card l-card--video ui-card--video">
        <h3 class="font-m">Web animation. The basics.</h3>
        <footer>
          <img class="square square-m" src="https://images.generated.photos/TeIvnowajO-bAz50Fw0hRvIjJd3-qNEqgVI1r_OBcm4/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zL3Yy/XzAyNDg5NTQuanBn.jpg" alt="Rosemary Stewart">
          <div class="font-s">
            <address>Randall Richards</address>
            <span>Art Director</span>
          </div>
        </footer>
      </article>
    </div>
  </section>
  
  <section class="l-teachers ui-teachers">
    <header>
      <h2>Top Teachers</h2>
      <button class="c-button l-button--nav ui-button--nav">
        <i class="fas fa-arrow-right"></i>
      </button>
    </header>
    <ul>
      <li>
        <img src="https://images.generated.photos/SZ43KV-Oo26-wpPUM7zDLo19CpGFH0eBnjegQFtvaUc/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zLzA4/NTUzMzguanBn.jpg" alt="Marvin Hawkins" class="circle circle--l">
        <div class="l-description ui-description">
          <p>Marvin Hawkins</p>
          <p>5 years experience</p>
        </div>
        <div class="ui-grade">5.0</div>
      </li>
      
      <li>
        <img src="https://images.generated.photos/eQu8qJ-cXfg-ntgifWreS0k6B8GH_7YCQbo45ijb_x4/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zL3Yy/XzA0MTc5NDAuanBn.jpg" alt="Arthur McKinney" class="circle circle--l">
        <div class="l-description ui-description">
          <p>Arthur McKinney</p>
          <p>6 years experience</p>
        </div>
        <div class="ui-grade">4.9</div>
      </li>
      
      <li>
        <img src="https://images.generated.photos/HfDYQfy2_MdmnFvMSGz-xtQMfwsnB9XlAw4G1j8Hlo4/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zLzAy/OTY2NTIuanBn.jpg" alt="Bessie Watson" class="circle circle--l">
        <div class="l-description ui-description">
          <p>Bessie Watson</p>
          <p>2 years experience</p>
        </div>
        <div class="ui-grade">4.8</div>
      </li>
      
      <li>
        <img src="https://images.generated.photos/DzhyqGgdtZFuKl01KszjW2PKmc1f3HxC9Agt-Efiz-c/rs:fit:512:512/Z3M6Ly9nZW5lcmF0/ZWQtcGhvdG9zLzA1/NTI3NzIuanBn.jpg" alt="Albert Bell" class="circle circle--l">
        <div class="l-description ui-descriptio">
          <p>Albert Bell</p>
          <p>3 years experience</p>
        </div>
        <div class="ui-grade">4.8</div>
      </li>
    </ul>
  </section>
</main>
</body>
</html>
