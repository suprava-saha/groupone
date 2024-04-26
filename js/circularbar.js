
let number = document.getElementById('number');
let rating = document.getElementById('rating')
let counter = 0;
let percentageofbar = 0
// Function to change the stroke-dashoffset value
function changeStrokeDashOffset(newValue) {
    if(newValue==0){
        percentageofbar = 0
        newValue= 450
        number.innerHTML=`${0}%`
    }else{
    
    newValue= newValue/5
    percentageofbar = newValue*100
    percentageofbar = Math.round(percentageofbar)
    newValue = newValue*450
    newValue = 450 - newValue

    newValue= Math.round(newValue)
    



    // Get all style sheets
    rating=newValue
    var styleSheets = document.styleSheets;
    console.log(styleSheets)

    // Loop through each style sheet
    for (var i = 0; i < styleSheets.length; i++) {
        var rules = styleSheets[i].cssRules || styleSheets[i].rules;

        // Loop through each rule in the style sheet
        for (var j = 0; j < rules.length; j++) {
            var rule = rules[j];

            // Check if the rule is a keyframes rule and its name is 'anim'
            if (rule.type === CSSRule.KEYFRAMES_RULE && rule.name === 'anim') {
                // Loop through each keyframe in the animation
                for (var k = 0; k < rule.cssRules.length; k++) {
                    var keyframe = rule.cssRules[k];

                    // Check if it's the 100% keyframe and update its property
                    if (keyframe.keyText === '100%') {
                        keyframe.style.strokeDashoffset = newValue;
                    }
                }
            }
        }
    }
}
        }

setInterval(()=>{
    if(counter ==percentageofbar){
        clearInterval;
    }else{
        counter +=1
    number.innerHTML=`${counter}%`

    }
    
}, 30)