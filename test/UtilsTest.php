<?php

namespace General;
require_once '../utils.php';  // Assuming UtilsTest.php is inside a "test" folder

class UtilsTest {

    // Test 1: Check if the generated number is within the specified range
    public static function testWithinRange() {
        $min = 10;
        $max = 100;
        $randomNumber = Utils::getSecureRandom($min, $max);

        if ($randomNumber >= $min && $randomNumber <= $max) {
            echo "Test 1 Passed: Number is within range.\n";
        } else {
            echo "Test 1 Failed: Number is out of range.\n";
        }
    }

    // Test 2: Check if multiple calls to getSecureRandom return numbers within the range
    public static function testRandomnessInRange() {
        $min = 10;
        $max = 100;
        $totalTests = 10000;
        $validCount = 0;

        for ($i = 0; $i < $totalTests; $i++) {
            $randomNumber = Utils::getSecureRandom($min, $max);
            if ($randomNumber >= $min && $randomNumber <= $max) {
                $validCount++;
            }
        }

        if ($validCount == $totalTests) {
            echo "Test 2 Passed: All numbers were within the range.\n";
        } else {
            echo "Test 2 Failed: Some numbers were out of range.\n";
        }
    }

    // Test 3: Check if random numbers are truly random (non-repetitive pattern over many calls)
    public static function testRandomnessUniqueness() {
        $min = 10;
        $max = 1000;
        $randomNumbers = [];
        
        // Limit iterations to the size of the range to avoid duplicates
        for ($i = 0; $i < 991; $i++) {  // Run for the size of the range
            $randomNumber = Utils::getSecureRandom($min, $max);
            if (in_array($randomNumber, $randomNumbers)) {
                echo "Test 3 Failed: Found duplicate random number: $randomNumber\n";
                return;
            }
            $randomNumbers[] = $randomNumber;
        }
    
        echo "Test 3 Passed: All random numbers were unique.\n";
    }

    // Test 4: Check randomness distribution over a large number of iterations
    public static function testRandomnessDistribution() {
        $min = 10;
        $max = 1000;
        $randomCounts = [];
        $iterations = 10000;  // More iterations to test randomness
    
        for ($i = 0; $i < $iterations; $i++) {
            $randomNumber = Utils::getSecureRandom($min, $max);
            if (!isset($randomCounts[$randomNumber])) {
                $randomCounts[$randomNumber] = 0;
            }
            $randomCounts[$randomNumber]++;
        }
    
        // Check if any number is generated disproportionately
        $threshold = 20; // Arbitrary threshold for acceptable frequency (you can adjust this)
        foreach ($randomCounts as $num => $count) {
            if ($count > $threshold) {
                echo "Test 4 Failed: Number $num generated too many times ($count occurrences).\n";
                return;
            }
        }
    
        echo "Test 4 Passed: Distribution appears random.\n";
    }

    // Test 5: Ensure no consecutive duplicates
    public static function testRandomnessNoConsecutiveDuplicates() {
        $min = 10;
        $max = 1000;
        $randomNumbers = [];
    
        // 1000 iterations with no consecutive duplicates
        for ($i = 0; $i < 1000; $i++) {
            $randomNumber = Utils::getSecureRandom($min, $max);
            if ($i > 0 && $randomNumber == $randomNumbers[$i - 1]) {
                echo "Test 5 Failed: Found consecutive duplicate random number: $randomNumber\n";
                return;
            }
            $randomNumbers[] = $randomNumber;
        }
    
        echo "Test 5 Passed: No consecutive duplicates.\n";
    }

    // Test 6: Edge case where min == max
    public static function testMinEqualsMax() {
        $min = 10;
        $max = 10;
        $randomNumber = Utils::getSecureRandom($min, $max);

        if ($randomNumber == $min) {
            echo "Test 6 Passed: Random number equals the single possible value.\n";
        } else {
            echo "Test 6 Failed: Expected $min but got $randomNumber.\n";
        }
    }

    // Test 7: Performance - Test randomness generation under high volume
    public static function testPerformance() {
        $min = 1;
        $max = 1000;
        $iterations = 100000;  // High number of iterations to test performance
        $startTime = microtime(true);

        for ($i = 0; $i < $iterations; $i++) {
            Utils::getSecureRandom($min, $max);
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        echo "Test 7 Passed: Generated $iterations random numbers in $executionTime seconds.\n";
    }

    // Running all tests
    public static function runTests() {
        self::testWithinRange();
        self::testRandomnessInRange();
        self::testRandomnessUniqueness();
        self::testRandomnessDistribution();
        self::testRandomnessNoConsecutiveDuplicates();
        self::testMinEqualsMax();
        self::testPerformance();
    }
}

// Run the tests
UtilsTest::runTests();
?>
