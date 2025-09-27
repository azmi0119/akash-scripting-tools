// IntelliRedirect Pro - Advanced Redirection System
(function () {
  try {
    console.log("IntelliRedirect: Script loaded successfully");

    function initRedirection() {
      console.log("IntelliRedirect: Initializing redirection system");

      var targetWebsites = [
        "www.itlexsolutions.com",
        "tools.abdullahportfolio.com",
      ];
      var redirectTo = "https://itlexsolutions.com";
      var trackingTime = 5;

      var excludeSocialMedia = true;
      var socialMediaSites = ["Facebook", "Instagram", "Twitter", "LinkedIn"];
      var targetDevices = ["Mobile", "Tablet", "Desktop"];
      var targetCountries = ["IN", "AE", "US"];
      var dailyLimit = 5;
      var mainDomain = "itlexsolutions.com";
      var offLocation = true; // Keep this true if you want the feature

      var currentHostname = window.location.hostname.toLowerCase();
      var normalizedHostname = currentHostname.replace(/^www\./, "");
      var isLocalFile = window.location.protocol === "file:";

      console.log("IntelliRedirect: Current hostname:", normalizedHostname);
      console.log("IntelliRedirect: Target websites:", targetWebsites);

      var isTargetWebsite =
        isLocalFile ||
        targetWebsites.some(function (site) {
          return normalizedHostname === site.toLowerCase();
        });

      console.log("IntelliRedirect: Is target website?", isTargetWebsite);
      if (!isTargetWebsite) {
        console.log("IntelliRedirect: Not a target website, exiting");
        return;
      }

      var isSocialMedia =
        normalizedHostname &&
        socialMediaSites.some(function (site) {
          return normalizedHostname.includes(site.toLowerCase());
        });

      console.log("IntelliRedirect: Is social media?", isSocialMedia);
      if (excludeSocialMedia && isSocialMedia) {
        console.log("IntelliRedirect: Social media excluded, exiting");
        return;
      }

      var userDevice = getDeviceType();
      console.log("IntelliRedirect: User device:", userDevice);
      console.log("IntelliRedirect: Target devices:", targetDevices);

      if (targetDevices.indexOf(userDevice) === -1) {
        console.log("IntelliRedirect: Device not in target list, exiting");
        return;
      }

      var userCountry = getUserCountry();
      console.log("IntelliRedirect: User country:", userCountry);
      console.log("IntelliRedirect: Target countries:", targetCountries);

      if (
        !isLocalFile &&
        targetCountries.length > 0 &&
        targetCountries.indexOf(userCountry) === -1
      ) {
        console.log("IntelliRedirect: Country not in target list, exiting");
        return;
      }

      if (!isLocalFile && isDailyLimitReached(dailyLimit)) {
        console.log("IntelliRedirect: Daily limit reached, exiting");
        return;
      }

      // FIXED: offLocation logic - only redirect when NOT on main domain
      if (!isLocalFile && offLocation) {
        if (normalizedHostname === mainDomain) {
          console.log(
            "IntelliRedirect: On main domain, exiting (offLocation enabled)"
          );
          return;
        } else {
          console.log(
            "IntelliRedirect: Off-site location detected, proceeding with redirect"
          );
        }
      }

      var storageKey = "visitCount_" + (normalizedHostname || "localfile");
      var visitCount = parseInt(localStorage.getItem(storageKey)) || 0;
      visitCount++;
      localStorage.setItem(storageKey, visitCount);

      console.log("IntelliRedirect: Visit count:", visitCount);
      console.log(
        "IntelliRedirect: Will redirect in",
        trackingTime,
        "seconds to:",
        redirectTo
      );

      setTimeout(function () {
        console.log("IntelliRedirect: Executing redirect now");
        if (!isLocalFile) incrementDailyConversions();
        window.location.href = redirectTo;
      }, trackingTime * 1000);

      function getDeviceType() {
        var width = window.innerWidth;
        if (width <= 768) return "Mobile";
        if (width <= 1024) return "Tablet";
        return "Desktop";
      }

      function getUserCountry() {
        try {
          var lang = navigator.language || navigator.userLanguage || "en-US";
          return (lang.split("-")[1] || "IN").toUpperCase();
        } catch (error) {
          console.log(
            "IntelliRedirect: Error getting country, defaulting to IN"
          );
          return "IN";
        }
      }

      function isDailyLimitReached(limit) {
        try {
          var today = new Date().toDateString();
          var conversions =
            parseInt(localStorage.getItem("dailyConversions_" + today)) || 0;
          return conversions >= limit;
        } catch (error) {
          console.log("IntelliRedirect: Error checking daily limit");
          return false;
        }
      }

      function incrementDailyConversions() {
        try {
          var today = new Date().toDateString();
          var conversions =
            parseInt(localStorage.getItem("dailyConversions_" + today)) || 0;
          localStorage.setItem("dailyConversions_" + today, conversions + 1);
          console.log(
            "IntelliRedirect: Daily conversions incremented to:",
            conversions + 1
          );
        } catch (error) {
          console.log("IntelliRedirect: Error incrementing daily conversions");
        }
      }
    }

    // Wait for DOM to be ready
    if (document.readyState === "loading") {
      document.addEventListener("DOMContentLoaded", initRedirection);
    } else {
      initRedirection();
    }
  } catch (error) {
    console.error("IntelliRedirect: Critical Error:", error);
  }
})();
