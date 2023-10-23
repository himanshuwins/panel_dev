// JavaScript Document
JQTWEET = {

Â Â Â Â // Set twitter username, number of tweets
Â Â Â Â user: 'EnvatoWebDesign',
Â Â Â Â numTweets: 3,
Â Â Â Â appendTo: '#jstwitter',
Â 
Â Â Â Â // core function of jqtweet
Â Â Â Â loadTweets: function() {
Â Â Â Â Â Â Â Â $.ajax({
Â Â Â Â Â Â Â Â Â Â Â Â url: 'http://api.twitter.com/1/statuses/user_timeline.json/',
Â Â Â Â Â Â Â Â Â Â Â Â type: 'GET',
Â Â Â Â Â Â Â Â Â Â Â Â dataType: 'jsonp',
Â Â Â Â Â Â Â Â Â Â Â Â data: {
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â screen_name: JQTWEET.user,
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â include_rts: true,
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â count: JQTWEET.numTweets,
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â include_entities: true
Â Â Â Â Â Â Â Â Â Â Â Â },
Â Â Â Â Â Â Â Â Â Â Â Â success: function(data, textStatus, xhr) {
Â 
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â var html = '<div class="tweet">TWEET_TEXT<div class="time">AGO</div>';
Â Â Â Â Â Â Â Â Â 
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â // append tweets into page
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â for (var i = 0; i < data.length; i++) {
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â $(JQTWEET.appendTo).append(
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â html.replace('TWEET_TEXT', JQTWEET.ify.clean(data[i].text) )
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â .replace(/USER/g, data[i].user.screen_name)
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â .replace('AGO', JQTWEET.timeAgo(data[i].created_at) )
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â .replace(/ID/g, data[i].id_str)
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â );
Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â }Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â Â  
Â Â Â Â Â Â Â Â Â Â Â Â }Â Â  
Â 
Â Â Â Â Â Â Â Â });
Â Â Â Â Â Â Â Â Â 
Â Â Â Â }, 
Â Â Â Â Â 
Â Â Â Â Â Â Â Â Â 
Â Â Â Â /**
Â Â Â Â Â Â * relative time calculator FROM TWITTER
Â Â Â Â Â Â * @param {string} twitter date string returned from Twitter API
Â Â Â Â Â Â * @return {string} relative time like "2 minutes ago"
Â Â Â Â Â Â */
Â Â Â Â timeAgo: function(dateString) {
Â Â Â Â Â Â Â Â var rightNow = new Date();
Â Â Â Â Â Â Â Â var then = new Date(dateString);
Â Â Â Â Â Â Â Â Â 
Â Â Â Â Â Â Â Â if ($.browser.msie) {
Â Â Â Â Â Â Â Â Â Â Â Â // IE can't parse these crazy Ruby dates
Â Â Â Â Â Â Â Â Â Â Â Â then = Date.parse(dateString.replace(/( \+)/, ' UTC$1'));
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â var diff = rightNow - then;
Â 
Â Â Â Â Â Â Â Â var second = 1000,
Â Â Â Â Â Â Â Â minute = second * 60,
Â Â Â Â Â Â Â Â hour = minute * 60,
Â Â Â Â Â Â Â Â day = hour * 24,
Â Â Â Â Â Â Â Â week = day * 7;
Â 
Â Â Â Â Â Â Â Â if (isNaN(diff) || diff < 0) {
Â Â Â Â Â Â Â Â Â Â Â Â return ""; // return blank string if unknown
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â if (diff < second * 2) {
Â Â Â Â Â Â Â Â Â Â Â Â // within 2 seconds
Â Â Â Â Â Â Â Â Â Â Â Â return "right now";
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â if (diff < minute) {
Â Â Â Â Â Â Â Â Â Â Â Â return Math.floor(diff / second) + " seconds ago";
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â if (diff < minute * 2) {
Â Â Â Â Â Â Â Â Â Â Â Â return "about 1 minute ago";
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â if (diff < hour) {
Â Â Â Â Â Â Â Â Â Â Â Â return Math.floor(diff / minute) + " minutes ago";
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â if (diff < hour * 2) {
Â Â Â Â Â Â Â Â Â Â Â Â return "about 1 hour ago";
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â if (diff < day) {
Â Â Â Â Â Â Â Â Â Â Â Â returnÂ  Math.floor(diff / hour) + " hours ago";
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â if (diff > day && diff < day * 2) {
Â Â Â Â Â Â Â Â Â Â Â Â return "yesterday";
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â if (diff < day * 365) {
Â Â Â Â Â Â Â Â Â Â Â Â return Math.floor(diff / day) + " days ago";
Â Â Â Â Â Â Â Â }
Â 
Â Â Â Â Â Â Â Â else {
Â Â Â Â Â Â Â Â Â Â Â Â return "over a year ago";
Â Â Â Â Â Â Â Â }
Â Â Â Â }, // timeAgo()
Â Â Â Â Â 
Â Â Â Â Â 
Â Â Â Â /**
Â Â Â Â Â Â * The Twitalinkahashifyer!
Â Â Â Â Â Â * http://www.dustindiaz.com/basement/ify.html
Â Â Â Â Â Â * Eg:
Â Â Â Â Â Â * ify.clean('your tweet text');
Â Â Â Â Â Â */
Â Â Â Â ify:Â  {
Â Â Â Â Â Â link: function(tweet) {
Â Â Â Â Â Â Â Â return tweet.replace(/\b(((https*\:\/\/)|www\.)[^\"\']+?)(([!?,.\)]+)?(\s|$))/g, function(link, m1, m2, m3, m4) {
Â Â Â Â Â Â Â Â Â Â var http = m2.match(/w/) ? 'http://' : '';
Â Â Â Â Â Â Â Â Â Â return '<a class="twtr-hyperlink" target="_blank" href="' + http + m1 + '">' + ((m1.length > 25) ? m1.substr(0, 24) + '...' : m1) + '</a>' + m4;
Â Â Â Â Â Â Â Â });
Â Â Â Â Â Â },
Â 
Â Â Â Â Â Â at: function(tweet) {
Â Â Â Â Â Â Â Â return tweet.replace(/\B[@ï¼ ]([a-zA-Z0-9_]{1,20})/g, function(m, username) {
Â Â Â Â Â Â Â Â Â Â return '<a target="_blank" class="twtr-atreply" href="http://twitter.com/intent/user?screen_name=' + username + '">@' + username + '</a>';
Â Â Â Â Â Â Â Â });
Â Â Â Â Â Â },
Â 
Â Â Â Â Â Â list: function(tweet) {
Â Â Â Â Â Â Â Â return tweet.replace(/\B[@ï¼ ]([a-zA-Z0-9_]{1,20}\/\w+)/g, function(m, userlist) {
Â Â Â Â Â Â Â Â Â Â return '<a target="_blank" class="twtr-atreply" href="http://twitter.com/' + userlist + '">@' + userlist + '</a>';
Â Â Â Â Â Â Â Â });
Â Â Â Â Â Â },
Â 
Â Â Â Â Â Â hash: function(tweet) {
Â Â Â Â Â Â Â Â return tweet.replace(/(^|\s+)#(\w+)/gi, function(m, before, hash) {
Â Â Â Â Â Â Â Â Â Â return before + '<a target="_blank" class="twtr-hashtag" href="http://twitter.com/search?q=%23' + hash + '">#' + hash + '</a>';
Â Â Â Â Â Â Â Â });
Â Â Â Â Â Â },
Â 
Â Â Â Â Â Â clean: function(tweet) {
Â Â Â Â Â Â Â Â return this.hash(this.at(this.list(this.link(tweet))));
Â Â Â Â Â Â }
Â Â Â Â } // ify
Â 
Â Â Â Â Â 
};