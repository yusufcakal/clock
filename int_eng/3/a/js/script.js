var nums = [1,2,34,54,55,34,32,11,19,17,54,66,13];
var evens = [];
var odds = [];

migrate(nums);


function migrate(nums) {
    for (var i = 0; i < nums.length; i++) {
        if ((nums[i] % 2) != 1) {
            evens.push(nums[i]);
        }else{
            odds.push(nums[i]);
        }
    }
};

var sumEven = 0;
for(var i=0; i<evens.length; i++){
    sumEven += evens[i];
}

var sumOdd = 0;
for(var i=0; i<odds.length; i++){
    sumOdd += odds[i];
}


alert(parseInt((sumOdd/odds.length) - (sumEven/evens.length)));