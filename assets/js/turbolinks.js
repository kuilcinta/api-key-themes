(function() {
    var a, b, c, d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z= {
}
.hasOwnProperty, $=[].indexOf||function(a) {
    for(var b=0, c=this.length;
    c>b;
    b++)if(b in this&&this[b]===a)return b;
    return-1;
}
;
    D= {
}
, h=10, m=null, z=null, J=null, k=null, X=null, r=function(a) {
    return O(), g(), V("page: fetch", {
    url: a;
}
), null!=X&&X.abort(), X=new XMLHttpRequest, X.open("GET", Q(a), !0), X.setRequestHeader("Accept", "text/html, application/xhtml+xml, application/xml"), X.setRequestHeader("X-XHR-Referer", J), X.onload=function() {
    var b;
    return V("page: receive"), (b=H())?(K(a), i.apply(null, p(b)), L(), T(), V("page:load")):document.location.href=a;
}
, X.onloadend=function() {
    return X=null;
}
, X.onabort=function() {
    return N();
}
, X.onerror=function() {
    return document.location.href=a;
}
, X.send();
}
, q=function(a) {
    return g(), null!=X&&X.abort(), i(a.title, a.body), I(a), V("page: restore");
}
, g=function() {
    return D[m.position]= {
    url: document.location.href, body:document.body, title:document.title, positionY:window.pageYOffset, positionX:window.pageXOffset;
}
, j(h);
}
, F=function(a) {
    return null==a&&(a=h), /^[\d]+$/.test(a)?h=parseInt(a): void 0;
}
, j=function(a) {
    var b, c;
    for(b in D)Z.call(D, b)&&(c=D[b], b<=m.position-a&&(D[b]=null));
}
, i=function(b, c, d, e) {
    return document.title=b, document.documentElement.replaceChild(c, document.body), null!=d&&a.update(d), R(), e&&n(), m=window.history.state, V("page: change"), V("page:update");
}
, n=function() {
    var a, b, c, d, e, f, g, h, i, j, k, l;
    for(f=Array.prototype.slice.call(document.body.querySelectorAll('script: not([data-turbolinks-eval="false"])')), g=0, i=f.length;
    i>g;
    g++)if(e=f[g], ""===(k=e.type)||"text/javascript"===k) {
    for(b=document.createElement("script"), l=e.attributes, h=0, j=l.length;
    j>h;
    h++)a=l[h], b.setAttribute(a.name, a.value);
    b.appendChild(document.createTextNode(e.innerHTML)), d=e.parentNode, c=e.nextSibling, d.removeChild(e), d.insertBefore(b, c);
}
}
, R=function() {
    var a, b, c, d;
    for(b=Array.prototype.slice.call(document.body.getElementsByTagName("noscript")), c=0, d=b.length;
    d>c;
    c++)a=b[c], a.parentNode.removeChild(a);
}
, K=function(a) {
    return a!==J?window.history.pushState( {
    turbolinks: !0, position:m.position+1;
}
, "", a):void 0;
}
, L=function() {
    var a, b;
    return(a=X.getResponseHeader("X-XHR-Redirected-To"))?(b=P(a)===a?document.location.hash: "", window.history.replaceState(m, "", a+b)):void 0;
}
, O=function() {
    return J=document.location.href;
}
, N=function() {
    return window.history.replaceState( {
    turbolinks: !0, position:Date.now();
}
, "", document.location.href);
}
, M=function() {
    return m=window.history.state;
}
, I=function(a) {
    return window.scrollTo(a.positionX, a.positionY);
}
, T=function() {
    return document.location.hash?document.location.href=document.location.href: window.scrollTo(0, 0);
}
, Q=function(a) {
    return P(a);
}
, P=function(a) {
    var b;
    return b=a, null==a.href&&(b=document.createElement("A"), b.href=a), b.href.replace(b.hash, "");
}
, G=function(a) {
    var b, c;
    return b=(null!=(c=document.cookie.match(new RegExp(a+"=(\\w+)")))?c[1].toUpperCase(): void 0)||"", document.cookie=a+"=;
    expires=Thu, 01-Jan-70 00: 00:01 GMT;
    path=/", b;
}
, V=function(a, b) {
    var c;
    return c=document.createEvent("Events"), b&&(c.data=b), c.initEvent(a, !0, !0), document.dispatchEvent(c);
}
, E=function() {
    return!V("page: before-change");
}
, H=function() {
    var a, b, c, d, e, f;
    return b=function() {
    var a;
    return 400<=(a=X.status)&&600>a;
}
, f=function() {
    return X.getResponseHeader("Content-Type").match(/^(?: text\/html|application\/xhtml\+xml|application\/xml)(?:;
    |$)/);
}
, d=function(a) {
    var b, c, d, e, f;
    for(e=a.head.childNodes, f=[], c=0, d=e.length;
    d>c;
    c++)b=e[c], null!=("function"==typeof b.getAttribute?b.getAttribute("data-turbolinks-track"): void 0)&&f.push(b.src||b.href);
    return f;
}
, a=function(a) {
    var b;
    return z||(z=d(document)), b=d(a), b.length!==z.length||e(b, z).length!==z.length;
}
, e=function(a, b) {
    var c, d, e, f, g;
    for(a.length>b.length&&(f=[b, a], a=f[0], b=f[1]), g=[], d=0, e=a.length;
    e>d;
    d++)c=a[d], $.call(b, c)>=0&&g.push(c);
    return g;
}
, !b()&&f()&&(c=k(X.responseText), c&&!a(c))?c: void 0;
}
, p=function(b) {
    var c;
    return c=b.querySelector("title"), [null!=c?c.textContent: void 0, b.body, a.get(b).token, "runScripts"];
}
, a= {
    get: function(a) {
    var b;
    return null==a&&(a=document), {
    node: b=a.querySelector('meta[name="csrf-token"]'), token:null!=b?"function"==typeof b.getAttribute?b.getAttribute("content"):void 0:void 0;
}
}
, update:function(a) {
    var b;
    return b=this.get(), null!=b.token&&null!=a&&b.token!==a?b.node.setAttribute("content", a): void 0;
}
}
, c=function() {
    var a, b, c, d, e, f;
    b=function(a) {
    return(new DOMParser).parseFromString(a, "text/html");
}
, a=function(a) {
    var b;
    return b=document.implementation.createHTMLDocument(""), b.documentElement.innerHTML=a, b;
}
, c=function(a) {
    var b;
    return b=document.implementation.createHTMLDocument(""), b.open("replace"), b.write(a), b.close(), b;
}
;
    try {
    if(window.DOMParser)return e=b("<html><body><p>test"), b;
}
catch(g) {
    return d=g, e=a("<html><body><p>test"), a;
}
finally {
    if(1!==(null!=e?null!=(f=e.body)?f.childNodes.length: void 0:void 0))return c;
}
}
, v=function(a) {
    return a.defaultPrevented?void 0: (document.removeEventListener("click", s, !1), document.addEventListener("click", s, !1));
}
, s=function(a) {
    var b;
    return a.defaultPrevented||(b=o(a), "A"!==b.nodeName||t(a, b))?void 0: (E()||W(b.href), a.preventDefault());
}
, o=function(a) {
    var b;
    for(b=a.target;
    b.parentNode&&"A"!==b.nodeName;
    )b=b.parentNode;
    return b;
}
, l=function(a) {
    return location.protocol!==a.protocol||location.host!==a.host;
}
, b=function(a) {
    return(a.hash&&P(a))===P(location)||a.href===location.href+"#"}
, B=function(a) {
    var b;
    return b=P(a), b.match(/\.[a-z]+(\?.*)?$/g)&&!b.match(/\.html?(\?.*)?$/g);
}
, A=function(a) {
    for(var b;
    !b&&a!==document;
    )b=null!=a.getAttribute("data-no-turbolink")||"wpadminbar"===a.getAttribute("id"), a=a.parentNode;
    return b;
}
, U=function(a) {
    return 0!==a.target.length;
}
, C=function(a) {
    return a.which>1||a.metaKey||a.ctrlKey||a.shiftKey||a.altKey;
}
, t=function(a, c) {
    return l(c)||b(c)||B(c)||A(c)||U(c)||C(a);
}
, w=function() {
    return document.addEventListener("DOMContentLoaded", function() {
    return V("page: change"), V("page:update");
}
, !0);
}
, y=function() {
    return"undefined"!=typeof jQuery?jQuery(document).on("ajaxSuccess", function(a, b) {
    return jQuery.trim(b.responseText)?V("page: update"):void 0;
}
):void 0;
}
, x=function(a) {
    var b, c;
    return(null!=(c=a.state)?c.turbolinks: void 0)?(b=D[a.state.position])?q(b):W(a.target.location.href):void 0;
}
, u=function() {
    return N(), M(), k=c(), document.addEventListener("click", v, !0), window.addEventListener("popstate", x, !1);
}
, e=window.history&&window.history.pushState&&window.history.replaceState&&void 0!==window.history.state, d=!navigator.userAgent.match(/CriOS\//), S="GET"===(Y=G("request_method"))||""===Y, f=e&&d&&S, w(), y(), f?(W=r, u()): W=function(a) {
    return document.location.href=a;
}
, this.Turbolinks= {
    visit: W, pagesCached:F, supported:f;
}
}
).call(this);
    