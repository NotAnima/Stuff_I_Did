#include <stdio.h>
#include <time.h>
#include "datastructures.h"

#define timeQuantum 2
#define BUFFER_SIZE 1024
#define MAXJOBS 6
#define ganttSize 64
#define TIMEUNIT 1
#define NUMBEROFALGOS 5

node* generateNode(int pidToAssign){ //generates a node with all the fields except for the pointers

    node* localNode = (node*)malloc(sizeof(node));
    if (localNode == NULL)
    {
        //error assigning memory location to this node
        return NULL;
    }

    int arrivalTime = rand() % 9;
    int burstTime = rand() % 8 + 3;
    int priority = rand() % 4 + 1;
    int timeLeft = burstTime; //initializes to the burst time
    int originalPriority = priority;
    int status = 0; //0 for inactive, 1 for active, must adjust everytime process gets pre-empted out
    int respondedFlag = 0;
    int justServiced = 0;

    localNode->pid = pidToAssign + 1;
    localNode->arrivalTime = arrivalTime;
    localNode->burstTime = burstTime;
    localNode->priority = priority;
    localNode->timeLeft = timeLeft;
    localNode->active = status;

    localNode->respondedFlag = respondedFlag;
    localNode->justServiced = justServiced;

    localNode->waitingTime = 0;
    localNode->turnAroundTime = 0;
    localNode->responseTime = 0;
    localNode->originalPriority = originalPriority;
    localNode->nextPtr = NULL;
    localNode->prevPtr = NULL;

    return localNode;
}

void insertAtHead(node* Node, linkerHead* addressHead)
{   
    if (Node == NULL)
    {
        return;
    }
    if (addressHead->head == NULL || addressHead->tail == NULL) //list is empty
    {

        addressHead->head = Node; 

        addressHead->tail = Node;

        return;
    }
    //if it's not the first node to insert, push the current head back and insert new one
    node *currentPtr = addressHead->head;

    Node->nextPtr = currentPtr;

    currentPtr->prevPtr = Node;

    addressHead->head = Node;
    //printf("Added Node that isn't the Head, address of Node: %p\n", Node);
}

void getNodeProperties(node* Node)
{
    if (Node == NULL)
    {
        return;
    }
    int pid = Node->pid;
    int arrivalTime = Node->arrivalTime;
    int burstTime = Node->burstTime;
    int priority = Node->priority;
    int timeLeft = Node->timeLeft;
    int turnaroundTime = Node->turnAroundTime;
    int waitingTime = Node->waitingTime;
    int responseTime = Node->responseTime;
    char formattedString[BUFFER_SIZE];

    sprintf(formattedString,"Pid: %d, Arrival: %d, Burst: %d, Priority: %d, Time Left: %d, Turn Around Time: %d, Waiting Time: %d, Response Time: %d", pid, arrivalTime, burstTime, priority, timeLeft, turnaroundTime, waitingTime, responseTime);
    send_to_file(formattedString);
}

void mergeByTimeLeft(node* arr[], node* left[], int leftSize, node* right[], int rightSize)
{
    int i = 0; // Index for left subarray

    int j = 0; // Index for right subarray

    int k = 0; // Index for merged array

    while (i < leftSize && j < rightSize)
     {
        if (left[i] != NULL && right[j] != NULL)
        {
            if (left[i]->timeLeft <= right[j]->timeLeft) 
            {
                arr[k++] = left[i++];
            }
            else 
            {
                arr[k++] = right[j++];
            }
        }

        else if(left[i] != NULL)
        {
            arr[k++] = left[i++];
        }
        else
        {
            arr[k++] = right[j++];
        }
    }


    // Copy remaining elements from left subarray, if any
    while (i < leftSize) 
    {
        arr[k++] = left[i++];
    }

    // Copy remaining elements from right subarray, if any
    while (j < rightSize) 
    {
        arr[k++] = right[j++];
    }
}

void mergeSortByTimeLeft(node* arr[], int size) 
{
    if (size < 2) 
    {
        return; // Base case: array of size 1 is already sorted
    }

    int mid = size / 2;
    node** left = malloc(mid * sizeof(node)); // Left subarray
    node** right = malloc((size - mid) * sizeof(node)); // Right subarray

    // Populate left subarray
    for (int i = 0; i < mid; i++) 
    {
        left[i] = arr[i];
    }

    // Populate right subarray
    for (int i = mid; i < size; i++) 
    {
        right[i-mid] = arr[i];
    }

    // Recursively sort the left and right subarrays
    mergeSortByTimeLeft(left, mid);
    mergeSortByTimeLeft(right, size - mid);

    // Merge the sorted left and right subarrays
    mergeByTimeLeft(arr, left, mid, right, (size - mid));
    free(left);
    free(right);
}

void mergeByBurst(node* arr[], node* left[], int leftSize, node* right[], int rightSize)
{
    int i = 0; // Index for left subarray

    int j = 0; // Index for right subarray

    int k = 0; // Index for merged array

    while (i < leftSize && j < rightSize)
     {
        if (left[i] != NULL && right[j] != NULL)
        {
            if (left[i]->burstTime <= right[j]->burstTime) 
            {
                arr[k++] = left[i++];
            }
            else 
            {
                arr[k++] = right[j++];
            }
        }

        else if(left[i] != NULL)
        {
            arr[k++] = left[i++];
        }
        else
        {
            arr[k++] = right[j++];
        }
    }


    // Copy remaining elements from left subarray, if any
    while (i < leftSize) 
    {
        arr[k++] = left[i++];
    }

    // Copy remaining elements from right subarray, if any
    while (j < rightSize) 
    {
        arr[k++] = right[j++];
    }
}

void mergeSortByBurst(node* arr[], int size) 
{
    if (size < 2) 
    {
        return; // Base case: array of size 1 is already sorted
    }

    int mid = size / 2;
    node** left = malloc(mid * sizeof(node)); // Left subarray
    node** right = malloc((size - mid) * sizeof(node)); // Right subarray

    // Populate left subarray
    for (int i = 0; i < mid; i++) 
    {
        left[i] = arr[i];
    }

    // Populate right subarray
    for (int i = mid; i < size; i++) 
    {
        right[i-mid] = arr[i];
    }

    // Recursively sort the left and right subarrays
    mergeSortByBurst(left, mid);
    mergeSortByBurst(right, size - mid);

    // Merge the sorted left and right subarrays
    mergeByBurst(arr, left, mid, right, (size - mid));
    free(left);
    free(right);
}

void mergeByArrival(node* arr[], node* left[], int leftSize, node* right[], int rightSize)
{
    int i = 0; // Index for left subarray

    int j = 0; // Index for right subarray

    int k = 0; // Index for merged array
    while (i < leftSize && j < rightSize)
     {
        if (left[i] != NULL && right[j] != NULL)
        {
            if (left[i]->arrivalTime <= right[j]->arrivalTime) 
            {
                arr[k++] = left[i++];
            }
            else 
            {
                arr[k++] = right[j++];
            }
        }

        else if(left[i] != NULL)
        {
            arr[k++] = left[i++];
        }
        else
        {
            arr[k++] = right[j++];
        }
    }

    // Copy remaining elements from left subarray, if any
    while (i < leftSize) 
    {
        arr[k++] = left[i++];
    }

    // Copy remaining elements from right subarray, if any
    while (j < rightSize) 
    {
        arr[k++] = right[j++];
    }
}

void mergeSortByArrival(node* arr[], int size) 
{
    if (size < 2) 
    {
        return; // Base case: array of size 1 is already sorted
    }

    int mid = size / 2;
    node** left = malloc(mid * sizeof(node)); // Left subarray
    node** right = malloc((size - mid) * sizeof(node)); // Right subarray

    // Populate left subarray
    for (int i = 0; i < mid; i++) 
    {
        left[i] = arr[i];
    }

    // Populate right subarray
    for (int i = mid; i < size; i++) 
    {
        right[i-mid] = arr[i];
    }

    // Recursively sort the left and right subarrays
    mergeSortByArrival(left, mid);
    mergeSortByArrival(right, size - mid);

    // Merge the sorted left and right subarrays
    mergeByArrival(arr, left, mid, right, (size - mid));
    free(left);
    free(right);
}

void mergeByPriority(node* arr[], node* left[], int leftSize, node* right[], int rightSize)
{
    int i = 0; // Index for left subarray

    int j = 0; // Index for right subarray

    int k = 0; // Index for merged array

    while (i < leftSize && j < rightSize)
     {
        if (left[i] != NULL && right[j] != NULL)
        {
            if (left[i]->priority <= right[j]->priority) 
            {
                arr[k++] = left[i++];
            }
            else 
            {
                arr[k++] = right[j++];
            }
        }

        else if(left[i] != NULL)
        {
            arr[k++] = left[i++];
        }
        else
        {
            arr[k++] = right[j++];
        }
    }


    // Copy remaining elements from left subarray, if any
    while (i < leftSize) 
    {
        arr[k++] = left[i++];
    }

    // Copy remaining elements from right subarray, if any
    while (j < rightSize) 
    {
        arr[k++] = right[j++];
    }
}

void mergeSortByPriority(node* arr[], int size) 
{
    if (size < 2) 
    {
        return; // Base case: array of size 1 is already sorted
    }

    int mid = size / 2;
    node** left = malloc(mid * sizeof(node)); // Left subarray
    node** right = malloc((size - mid) * sizeof(node)); // Right subarray

    // Populate left subarray
    for (int i = 0; i < mid; i++) 
    {
        left[i] = arr[i];
    }

    // Populate right subarray
    for (int i = mid; i < size; i++) 
    {
        right[i-mid] = arr[i];
    }

    // Recursively sort the left and right subarrays
    mergeSortByPriority(left, mid);
    mergeSortByPriority(right, size - mid);

    // Merge the sorted left and right subarrays
    mergeByPriority(arr, left, mid, right, (size - mid));
    free(left);
    free(right);
}

void mergeByPid(node* arr[], node* left[], int leftSize, node* right[], int rightSize)
{
    int i = 0; // Index for left subarray

    int j = 0; // Index for right subarray

    int k = 0; // Index for merged array

    while (i < leftSize && j < rightSize)
     {
        if (left[i] != NULL && right[j] != NULL)
        {
            if (left[i]->pid <= right[j]->pid) 
            {
                arr[k++] = left[i++];
            }
            else 
            {
                arr[k++] = right[j++];
            }
        }

        else if(left[i] != NULL)
        {
            arr[k++] = left[i++];
        }
        else
        {
            arr[k++] = right[j++];
        }
    }


    // Copy remaining elements from left subarray, if any
    while (i < leftSize) 
    {
        arr[k++] = left[i++];
    }

    // Copy remaining elements from right subarray, if any
    while (j < rightSize) 
    {
        arr[k++] = right[j++];
    }
}

void mergeSortByPid(node* arr[], int size) 
{
    if (size < 2) 
    {
        return; // Base case: array of size 1 is already sorted
    }

    int mid = size / 2;
    node** left = malloc(mid * sizeof(node)); // Left subarray
    node** right = malloc((size - mid) * sizeof(node)); // Right subarray

    // Populate left subarray
    for (int i = 0; i < mid; i++) 
    {
        left[i] = arr[i];
    }

    // Populate right subarray
    for (int i = mid; i < size; i++) 
    {
        right[i-mid] = arr[i];
    }

    // Recursively sort the left and right subarrays
    mergeSortByPid(left, mid);
    mergeSortByPid(right, size - mid);

    // Merge the sorted left and right subarrays
    mergeByPid(arr, left, mid, right, (size - mid));
    free(left);
    free(right);
}

void sortForFCFS(node* jobQueue[], int size)
{
    mergeSortByPid(jobQueue, size);
    mergeSortByBurst(jobQueue, size);
    mergeSortByArrival(jobQueue, size);
}

void sortForSJF(node* jobQueue[], int size)
{
    mergeSortByPid(jobQueue, size);
    mergeSortByArrival(jobQueue, size);
    mergeSortByBurst(jobQueue, size);
}

void sortForSRTF(node* jobQueue[], int size)
{
    mergeSortByPid(jobQueue, size);
    mergeSortByArrival(jobQueue, size);
    mergeSortByTimeLeft(jobQueue, size);
}

void sortForPriority(node* jobQueue[], int size)
{
    mergeSortByPid(jobQueue, size);
    mergeSortByArrival(jobQueue, size);
    mergeSortByTimeLeft(jobQueue, size);
    mergeSortByPriority(jobQueue, size);
}

int get_choice()
{
    char text[BUFFER_SIZE];
    fputs("Choose between choice 1 and 5:\n1) First Come First Serve Algorithm\n2) Shortest Job First Algorithm\n3) Shortest Remaining Time First Algorithm\n4) Round-Robin Algorithm\n5) Priority Algorithm\n\nPick Your Choice Here >> ", stdout);
    fflush(stdout);
    if ( fgets(text, sizeof text, stdin) ) {
        int number;
        if ( sscanf(text, "%d", &number) == 1 ) {
            return number;
        }
    }   
    return 0;
}

int getPreempChoice()
{
    char text[BUFFER_SIZE];
    fputs("Choose whether you want Priority Scheduling to be pre-emptive or not\n1) Yes\n2) No\n\nPick Your Choice Here >> ", stdout);
    fflush(stdout);
    if ( fgets(text, sizeof text, stdin) ) {
        int number;
        if ( sscanf(text, "%d", &number) == 1 ) {
            return number;
        }
    }   
    return 0;
}

void send_to_file(char message[]){
  FILE *fptr;

  fptr = fopen("Q2_Group_03.txt", "a");
  if (fptr == NULL)
  {
    fptr = fopen("Q2_Group_03.txt", "w");
    if (fptr == NULL)
    {
        printf("\nError writing out to file.\n");
        exit(1);
    }
  }

  fprintf(fptr, "%s\n", message);
  fclose(fptr);
}

int checkValidity(node* jobQueue[])
{
    if (checkForGap(jobQueue, MAXJOBS))
    {
        return 0;
    }

    return 1; //1 IFF all the nodes are valid
}

void placeJobs(node* jobQueue[], linkerHead* head, int size)
{

    head->head = NULL; //reset the list then point all the nodes back to the linkedList
    head->tail = NULL;

    for (int i = 0; i < size; i++)
    {
        if (jobQueue[i] == NULL)
        {
            continue;
        }
        jobQueue[i]->nextPtr = NULL;
        jobQueue[i]->prevPtr = NULL;
        insertAtHead(jobQueue[i], head);
    }
}

void placeArrivedJobs(node* jobQueue[], node* readyArray[], int elapsedTime)
{   
    for (int i = 0; i < MAXJOBS; i++)
    {
        if (jobQueue[i] == NULL)
        {
            continue;
        }
        else if(jobQueue[i]->arrivalTime <= elapsedTime && jobQueue[i]->timeLeft != 0 && jobQueue[i]->active == 0)
        {
            jobQueue[i]->active = 1; //it is now active
            int j = 0;
            while (readyArray[j] != NULL) //search for the first open slot in the readyArray
            {
                j++;
            }
            readyArray[j] = jobQueue[i]; //places the address of a ready process into the readyArray
        }

    }
}

void destroyJobQueue(node* jobQueue[])
{

    for (int i = 0; i < MAXJOBS; i++)
    {
        if (jobQueue[i] == NULL)
        {
            continue;
        }
        free(jobQueue[i]); //free jobs
        jobQueue[i] = NULL;
    }
}

void destroyGanttArray(ganttStruct* ganttOrder[])
{

    for (int i = 0; i < ganttSize; i++)
    {
        if (ganttOrder[i] == NULL)
        {
            continue;
        }
        free(ganttOrder[i]);
        ganttOrder[i] = NULL;
    }
}

void resetProcesses(node* jobQueue[], int size, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[])
{
    destroyGanttArray(ganttOrder);
    destroyGanttArray(ganttBlocks);
    
    mergeSortByPid(jobQueue, size);
    for (int i = 0; i < size; i++)
    {
        if (jobQueue[i] == NULL)
        {
            continue;
        }
        jobQueue[i]->active = 0; //reset active status
        jobQueue[i]->priority = jobQueue[i]->originalPriority; //resets priority
        jobQueue[i]->timeLeft = jobQueue[i]->burstTime;

        jobQueue[i]->turnAroundTime = 0;
        jobQueue[i]->waitingTime = 0;
        jobQueue[i]->responseTime = 0;
        jobQueue[i]->respondedFlag = 0;

        jobQueue[i]->nextPtr = NULL;
        jobQueue[i]->prevPtr = NULL;
    }

}

void normalizeData(node* jobQueue[])
{
    int lowestArrivalTime = 9;
    for (int i = 0; i < MAXJOBS; i++)
    {
        if (jobQueue[i] == NULL)
        {
            continue;
        }
        if (jobQueue[i]->arrivalTime < lowestArrivalTime)
        {
            if(jobQueue[i]->arrivalTime == 0)
            {
                //printf("\nThere was a Job with 0 time units\n");
                return; //that means there is at least 1 job that has arrivalTime of 0, so there's no need to go any further
            }
            lowestArrivalTime = jobQueue[i]->arrivalTime;
            //printf("\nLowestArrivalTime inside the loop is %d\n", lowestArrivalTime);
        }
    } //find the lowest arrivaltime of all the existing jobs in the jobQueue

    for (int i = 0; i < MAXJOBS; i++)
    {
        if (jobQueue[i] == NULL)
        {
            continue;
        }
        jobQueue[i]->arrivalTime -= lowestArrivalTime;
    } //this functions makes sure that there exists at least ONE node that = 0 arrivalTime, fixing all the turnAroundTime calculation issues for universe starts at != 0
}

void makeJobs(node* jobQueue[], int* validJobs, int* emergencyBreak)
{
    for (int i = 0; i < MAXJOBS; i++) // does the actual job generation
    {
      jobQueue[i] = generateNode(i);
    }
    *validJobs = checkValidity(jobQueue); // if valid then will break out of while Loop
    if (!validJobs)
    {
      printf("\nDestroying job because it wasn't valid\n");  
      destroyJobQueue(jobQueue); // free all jobs in the Queue and destroy the nodes
      *emergencyBreak++;

      if (*emergencyBreak == 500) //to prevent infinite loop
      {
        printf("\nReally did not want get proper jobs...\n");
        return;
      }
    }
}

void makeJobsForFCFS(node* jobQueue[], int* validJobs, int* emergencyBreak)
{
    int generatedBurst = rand() % 8 + 3;
    for (int i = 0; i < MAXJOBS; i++) // does the actual job generation
    {
      jobQueue[i] = generateNode(i);
    }
    *validJobs = checkValidity(jobQueue); // if valid then will break out of while Loop
    if (!validJobs)
    {
      printf("\nDestroying job because it wasn't valid\n");  
      destroyJobQueue(jobQueue); // free all jobs in the Queue and destroy the nodes
      *emergencyBreak++;

      if (*emergencyBreak == 500) //to prevent infinite loop
      {
        printf("\nReally did not want get proper jobs...\n");
        return;
      }
    }
}

void makeJobsForSJF(node* jobQueue[], int* validJobs, int* emergencyBreak, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[])
{

    generateNoGaps(jobQueue);

    *validJobs = handleCheck(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    if(*validJobs == 1)
    {
        resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
        return;
    }

    while(*validJobs != 1)
    {
        *emergencyBreak++;
        if(*emergencyBreak == 500)
        {
            return;
        }
        resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
        destroyJobQueue(jobQueue);
        generateNoGaps(jobQueue);
        *validJobs = handleCheck(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
        if(*validJobs == 1)
        {
            break;
        }
    }
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
    return;

}

void makeJobsForPriority(node* jobQueue[], int* validJobs, int* emergencyBreak, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[])
{
    generateNoGaps(jobQueue);

    *validJobs = handleCheckPriority(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);

    if(*validJobs == 1)
    {
        resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
        return;
    }

    while(*validJobs != 1)
    {   
        *emergencyBreak++;
        if(*emergencyBreak == 500)
        {
            return;
        }
        resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
        destroyJobQueue(jobQueue);
        generateNoGapsPriority(jobQueue);
        *validJobs = handleCheckPriority(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
        if(*validJobs == 1)
        {
            break;
        }
    }
    resetProcesses(jobQueue, MAXJOBS, ganttOrder, ganttBlocks);
    return;

}

void writeOutAverageTimes(char *schedulingType, int totalTurnAroundTime, float totalWaitingTime, float totalResponseTime, winner* winnerArray[], node* readyArray[])
{
    char formattedString[BUFFER_SIZE];

    float averageTurnAroundTime = ((float)totalTurnAroundTime) / MAXJOBS;

    float averageWaitingTime = ((float)totalWaitingTime) / MAXJOBS;

    float averageResponseTime = ((float)totalResponseTime) / MAXJOBS;

    addToWinnerArray(winnerArray, schedulingType, readyArray, averageTurnAroundTime, averageWaitingTime, averageResponseTime);

    sprintf(formattedString, "\nFOR [%s] ALGORITHM AVERAGES:\nAverage Turn Around Time: %.2f, Average Waiting Time: %.2f, Average Response Time: %.2f\n------------------------------------------------------------------------------------------------------------------\n", schedulingType, averageTurnAroundTime, averageWaitingTime, averageResponseTime);
    printf("%s", formattedString);              
    send_to_file(formattedString);
}

void calculateAverageTimes(node* readyQueue[], char schedulingType[], winner *winnerArray[])
{
    int totalTurnAroundTime = 0;
    int totalWaitingTime = 0;
    int totalResponseTime = 0;

    for(int i = 0; i < MAXJOBS; i++)
    {
        if(readyQueue[i] == NULL)
        {   
            printf("\nFatal Error occured in calculating Average Times function\n");
            continue; //shouldn't happen, if it does, something fatal happened
        }
        totalTurnAroundTime += readyQueue[i]->turnAroundTime;
        totalWaitingTime += readyQueue[i]->waitingTime;
        totalResponseTime += readyQueue[i]->responseTime;
    }
    
    writeOutAverageTimes(schedulingType, totalTurnAroundTime, totalWaitingTime, totalResponseTime, winnerArray, readyQueue);
    return;
}

int checkForGap(node* jobQueue[], int size)
{
    int elapsedTime = 0;
    int actualTime = 0;
    mergeSortByArrival(jobQueue, size);
    for (int i = 0; i < size; i++)
    {
        node* currentProcess = jobQueue[i];
        if (currentProcess->arrivalTime > elapsedTime)
        {
            return 1; //there is a gap in the process
        }
        int burstTime = currentProcess->timeLeft;
        elapsedTime += burstTime;

    }

    return 0;
}

int countArraySize(node* jobQueue[], int size)
{
    int numberOfNULLS = 0;
    for (int i = 0; i < size; i++)
    {
        if (jobQueue[i] == NULL)
        {
            numberOfNULLS++;
        }
    }
    return (size-numberOfNULLS);
}

int countGanttSize(ganttStruct* ganttOrder[], int size)
{
    int numberOfNULLS = 0;
    for (int i = 0; i < size; i++)
    {
        if (ganttOrder[i] == NULL)
        {
            numberOfNULLS++;
        }
    }
    return (size-numberOfNULLS);
}

int allAreEmpty(node* readyArray[], int size)
{
    //printf("\nChecking if they are all done\n");
    int numberOfDoneJobs = 0;
    for(int i = 0; i < size; i++)
    {
        if(readyArray[i] == NULL)//if it was NULL, means there were still jobs not pushed anyway
        {
            //printf("This was NULL returning false\n");
            return 0;
        }
        if(readyArray[i]->timeLeft == 0)
        {
            numberOfDoneJobs++;
        }
        //printf("i is %d\n",i);
    }

    if(numberOfDoneJobs == size)
    {
        //printf("all of them were finished\n");
        return 1;
    }
    //printf("\nThere were undone jobs\n");
    return 0;
}

void insertIntoGanttOrder(node* currentProcess, ganttStruct* ganttOrder[], int currentlyElapsedTime)
{
    //printf("\nEntered insertIntoGanttOrder\n");
    ganttStruct *localGantt = (ganttStruct*)malloc(sizeof(ganttStruct));
    localGantt -> timeBlock = currentlyElapsedTime;
    localGantt -> pid = currentProcess -> pid;
    int firstFreeIndex = 0;
    while(ganttOrder[firstFreeIndex] != NULL)
    {
        firstFreeIndex++;
    }
    ganttOrder[firstFreeIndex] = localGantt;
}

void insertGanttBlock(ganttStruct* ganttBlocks[], ganttStruct* ganttBlockToInsert)
{
    //printf("\nEntered insertIntoGanttBlocks\n");
    int firstFreeIndex = 0;
    while(ganttBlocks[firstFreeIndex] != NULL)
    {
        firstFreeIndex++;
    }
    ganttBlocks[firstFreeIndex] = ganttBlockToInsert;
}

int getGanttBlocks(ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[], char schedulingType[])
{
    int isItRR = strcmp(schedulingType, "RR"); //0 if string is equal
    if (isItRR != 0)
    {
        ganttStruct* previousGanttAddress = NULL;
        ganttStruct* currentGanttAddress = NULL;
        int currentStreak = 0;
        ganttStruct* nextGanttAddress = NULL;
        int size = countGanttSize(ganttOrder, ganttSize);
        //printf("\nganttOrder size value is %d\n",size);
        for(int i = 0; i < size; i++)
        {
            //printf("Entered getGanttBlocksForLoop Iteration i = %d\n", i);
            previousGanttAddress = currentGanttAddress;
            currentGanttAddress = ganttOrder[i];
            nextGanttAddress = ganttOrder[i+1];
            if (currentGanttAddress == NULL) //no more ganttOrders to check
            {
                //printf("\ni value at break is %d\n",i);
                break;
            }
            while(samePid(currentGanttAddress, nextGanttAddress))
            {
                previousGanttAddress = currentGanttAddress;
                currentGanttAddress = nextGanttAddress;
                i++;
                nextGanttAddress = ganttOrder[i+1];
                if(i == size-1)
                {
                    //printf("i value has reached the last ganttOrder");
                    int mostRelevantElapsedTime = currentGanttAddress->timeBlock;
                    int pid = currentGanttAddress->pid;
                    ganttStruct *localGantt = (ganttStruct*)malloc(sizeof(ganttStruct));
                    localGantt -> timeBlock = mostRelevantElapsedTime;
                    localGantt -> pid = pid;
                    insertGanttBlock(ganttBlocks, localGantt);
                    currentStreak = 0;
                    return 0;
                }
                //printf("i value in samePid() is %d\n",i);
            }
            if(!samePid(currentGanttAddress, nextGanttAddress)) //if they are different, that means that the streak is over and it is safe to insert a block
            {
                //printf("\nwere not the same pid, inserting block now\n");
                int mostRelevantElapsedTime = currentGanttAddress->timeBlock;
                int pid = currentGanttAddress->pid;
                ganttStruct *localGantt = (ganttStruct*)malloc(sizeof(ganttStruct));
                localGantt -> timeBlock = mostRelevantElapsedTime;
                localGantt -> pid = pid;
                insertGanttBlock(ganttBlocks, localGantt);
                currentStreak = 0;
                //printf("\nFinished the first ganttBlock\n");
                //printf("i value at end of ganttBlock is %d\n", i);
                continue;
            }
            else
            {
                printf("\nFatal Error occured\n");
            }
        }
        return 0;
    }
    


    else //if the schedulingType is Round-Robin, then do this
    {
        //printf("It is round-robin schedulingType\n");
        //printf("ganttOrder size is %d\n", countGanttSize(ganttOrder, ganttSize));
        ganttStruct* previousGanttAddress = NULL;
        ganttStruct* currentGanttAddress = NULL;
        int currentStreak = 0;
        ganttStruct* nextGanttAddress = NULL;
        int size = countGanttSize(ganttOrder, ganttSize);
        //printf("\nganttOrder size value is %d\n",size);
        for(int i = 0; i < size; i++)
        {
            //printf("Entered getGanttBlocksForLoop Iteration i = %d\n", i);
            previousGanttAddress = currentGanttAddress;
            currentGanttAddress = ganttOrder[i];
            nextGanttAddress = ganttOrder[i+1];
            if (currentGanttAddress == NULL) //no more ganttOrders to check
            {
                //printf("\ni value at break is %d\n",i);
                return 0;
            }
            //printf("i value has reached the last ganttOrder");
            int mostRelevantElapsedTime = currentGanttAddress->timeBlock;
            int pid = currentGanttAddress->pid;
            ganttStruct *localGantt = (ganttStruct*)malloc(sizeof(ganttStruct));
            localGantt -> timeBlock = mostRelevantElapsedTime;
            localGantt -> pid = pid;
            insertGanttBlock(ganttBlocks, localGantt);
            //printf("Successfully inserted ganttBlock i value is: %d\n", i);
            currentStreak = 0;
            //printf("i value in samePid() is %d\n",i);
        }
        
    }

    return 0;
}

int samePid(ganttStruct* currentGanttAddress, ganttStruct* nextGanttAddress)
{
    if(nextGanttAddress == NULL)
    {
        return 0;
    }
    if(nextGanttAddress->pid == currentGanttAddress->pid)
    {
        return 1;
    }
    return 0;
}

void appendToBuffer(char* buffer, const char* str)
{
    size_t buffer_len = strlen(buffer);
    size_t str_len = strlen(str);
    size_t i;

    if (buffer_len + str_len >= BUFFER_SIZE) {
        printf("Error: Buffer overflow!\n");
        return;
    }

    for (i = 0; i < str_len; i++) {
        buffer[buffer_len + i] = str[i];
    }
    buffer[buffer_len + i] = '\0'; // Null-terminate the resulting string
}

void writeGanttChart(ganttStruct* ganttBlocks[], char schedulingType[])
{
    char lastOfFirstLine[BUFFER_SIZE] = "+";
    char lastOfSecondLine[BUFFER_SIZE] = "|";
    char lastOfThirdLine[BUFFER_SIZE] = "+";

    char firstLine[BUFFER_SIZE] = "+----";
    //char secondLine[BUFFER_SIZE] = "| P3 ";
    char secondLine[BUFFER_SIZE] = " ";
    char thirdLine[BUFFER_SIZE] = "+----";

    char lineBreak[BUFFER_SIZE] = "\n";
    
    int elapsedTime = 0;
    char elapsedTimeString[BUFFER_SIZE] = " ";
    char buffer[BUFFER_SIZE] = "";
    char ganttChartFor[BUFFER_SIZE] = " ";

    sprintf(ganttChartFor, "Gantt Chart For [%s]:\n", schedulingType);
    appendToBuffer(buffer, ganttChartFor);

    int noOfGanttBlocks = countGanttSize(ganttBlocks, ganttSize);
    //printf("Before appending: \n%s\n", buffer);
/*******************************************************************************/
    for (int i = 0; i < noOfGanttBlocks; i++) //top row
    {
        ganttStruct* currentBlock = ganttBlocks[i];
        if(currentBlock == NULL)
        {
            appendToBuffer(buffer, lastOfFirstLine);
            break;
        }
        else
        {
            appendToBuffer(buffer, firstLine);
        }
    }
    appendToBuffer(buffer, lastOfFirstLine);
    appendToBuffer(buffer, lineBreak);
/*******************************************************************************/
    for (int i = 0; i < noOfGanttBlocks; i++) //2nd row (Process numbers)
    {
        ganttStruct* currentBlock = ganttBlocks[i];
        sprintf(secondLine, "| P%d ", currentBlock->pid);
        if(currentBlock == NULL)
        {
            appendToBuffer(buffer, lastOfSecondLine);
            break;
        }
        else
        {
            appendToBuffer(buffer, secondLine);
        }
    }
    appendToBuffer(buffer, lastOfSecondLine);
    appendToBuffer(buffer, lineBreak);
/*******************************************************************************/
    for (int i = 0; i < noOfGanttBlocks; i++) //3rd row (bottom of the gantt chart)
    {
        ganttStruct* currentBlock = ganttBlocks[i];
        if(currentBlock == NULL)
        {
            appendToBuffer(buffer, lastOfThirdLine);
            break;
        }
        else
        {
            appendToBuffer(buffer, thirdLine);
        }
    }
    appendToBuffer(buffer, lastOfThirdLine);
    appendToBuffer(buffer, lineBreak);
/*******************************************************************************/
    for (int i = 0; i < noOfGanttBlocks; i++) //4th row (timer of the gantt chart)
    {
        if (i == 0)
        {
            sprintf(elapsedTimeString, "%d    ", elapsedTime);
            appendToBuffer(buffer, elapsedTimeString);
        }

        ganttStruct* currentBlock = ganttBlocks[i];
        if(currentBlock == NULL)
        {
            break;
        }
        elapsedTime = currentBlock -> timeBlock;
        sprintf(elapsedTimeString, "%d   ", elapsedTime);
        int size = strlen(elapsedTimeString);
        if(size == 4)
        {
            sprintf(elapsedTimeString, "%d    ", elapsedTime);
            //elapsedTime += 3;
            appendToBuffer(buffer, elapsedTimeString);
        }
        else
        {
            //elapsedTime += 3;
            appendToBuffer(buffer, elapsedTimeString);
        }
    }
    //appendToBuffer(buffer, lineBreak);
/*******************************************************************************/
    send_to_file(buffer);
    printf("%s\n", buffer);
}

void drawTable(node* jobQueue[])
{
    char topOfTable[BUFFER_SIZE] = "+-----------+--------------+------------+----------+\n| Processes | Arrival Time | Burst Time | Priority |\n+-----------+--------------+------------+----------+\n";

    char lineSeparator[BUFFER_SIZE] = "+-----------+--------------+------------+----------+\n";                    
    char actualTable[BUFFER_SIZE] = "";

    appendToBuffer(actualTable, topOfTable);
    for(int i = 0; i < MAXJOBS; i++)
    {

        char processBoxToInsert[BUFFER_SIZE] = " ";
        sprintf(processBoxToInsert, "|    P%d     ", jobQueue[i]->pid);

        char arrivalBoxToInsert[BUFFER_SIZE] = " "; 
        sprintf(arrivalBoxToInsert, "|      %d       ", jobQueue[i]->arrivalTime);

        char burstTimeString[BUFFER_SIZE] = " ";
        sprintf(burstTimeString, "%d", jobQueue[i]->burstTime);

        int burstStrLen = strlen(burstTimeString);
        char burstTimeBoxToInsert[BUFFER_SIZE] =  "";

        if(burstStrLen == 1)
        {
            sprintf(burstTimeBoxToInsert, "|     %d      ", jobQueue[i]->burstTime);
        }
        else
        {
            sprintf(burstTimeBoxToInsert, "|     %d     ", jobQueue[i]->burstTime);
        }

        char priorityBoxToInsert[BUFFER_SIZE] = " ";

        sprintf(priorityBoxToInsert, "|     %d    ", jobQueue[i]->priority);

        char closingUpRightSide[BUFFER_SIZE] = "|\n";

        char closingBottom[BUFFER_SIZE] = "+-----------+--------------+------------+----------+\n";

        appendToBuffer(actualTable, processBoxToInsert);
        appendToBuffer(actualTable, arrivalBoxToInsert);
        appendToBuffer(actualTable, burstTimeBoxToInsert);
        appendToBuffer(actualTable, priorityBoxToInsert);
        appendToBuffer(actualTable, closingUpRightSide);
        appendToBuffer(actualTable, closingBottom);
    }

    send_to_file(actualTable);
    printf("%s\n", actualTable);

}

void freeWinnerArray(winner *array[])
{
    for (int i = 0; i < MAXJOBS; i++)
    {
        if (array[i] == NULL)
        {
            continue;
        }
        free(array[i]); //free jobs
        array[i] = NULL;
    }
}

void addToWinnerArray(winner *winnerArray[], char *schedulingType, node* readyArray[], float averageTurnAroundTime, float averageWaitingTime, float averageResponseTime)
{
    winner *localWinner = (winner*)malloc(sizeof(winner));

    if (localWinner == NULL)
    {
        return;
    }

    if(strcmp(schedulingType, "FCFS") == 0)
    {
        localWinner -> schedulingType = 0;
    }

    else if(strcmp(schedulingType, "SJF") == 0)
    {
        localWinner -> schedulingType = 1;
    }

    else if(strcmp(schedulingType, "SRTF") == 0)
    {
        localWinner -> schedulingType = 2;
    }

    else if(strcmp(schedulingType, "RR") == 0)
    {
        localWinner -> schedulingType = 3;
    }

    else if(strcmp(schedulingType, "Priority") == 0)
    {
        localWinner -> schedulingType = 4;
    }

    localWinner -> averageTurnAroundTime = averageTurnAroundTime;

    localWinner -> averageWaitingTime = averageWaitingTime;
    
    localWinner -> averageResponseTime = averageResponseTime;

    int indexToAddWinner = localWinner -> schedulingType;

    winnerArray[indexToAddWinner] = localWinner;

    return;
}

void didIWin(winner *winnerArray[], int choice)
{
    int indexOfWinner = choice - 1;

    int wonTurnAround = 0;
    int wonWaiting = 0;
    int wonResponse = 0;

    int wonSomething = 0;

    float arrayOfTurnArounds[NUMBEROFALGOS];
    float arrayOfWaits[NUMBEROFALGOS];
    float arrayOfResponse[NUMBEROFALGOS];

    int numberOfEqualsOrLessTurnArounds = 0;
    int numberOfEqualsOrLessWaits = 0;
    int numberOfEqualsOrLessResponses = 0;

    for(int i = 0; i < NUMBEROFALGOS; i++)
    {
        if(winnerArray[i] == NULL)
        {
            continue;
        }

        arrayOfTurnArounds[i] = winnerArray[i]->averageTurnAroundTime;
        arrayOfWaits[i] = winnerArray[i]->averageWaitingTime;
        arrayOfResponse[i] = winnerArray[i]->averageResponseTime;

    }

    for(int i = 0; i < NUMBEROFALGOS; i++)
    {
        if(arrayOfTurnArounds[indexOfWinner] <= arrayOfTurnArounds[i])
        {
            numberOfEqualsOrLessTurnArounds++;
        }

        if(arrayOfWaits[indexOfWinner] <= arrayOfWaits[i])
        {
            numberOfEqualsOrLessWaits++;
        }

        if(arrayOfResponse[indexOfWinner] <= arrayOfResponse[i])
        {
            numberOfEqualsOrLessResponses++;
        }
    }

    if(numberOfEqualsOrLessTurnArounds == 5)
    {
        wonSomething = 1;
        wonTurnAround = 1;
    }

    if(numberOfEqualsOrLessWaits == 5)
    {
        wonSomething = 1;
        wonWaiting = 1;
    }

    if(numberOfEqualsOrLessResponses == 5)
    {
        wonSomething = 1;
        wonResponse = 1;
    }

    char winnerMsg[BUFFER_SIZE] = "";

    if(choice == 1)
    {   
        appendToBuffer(winnerMsg, "FCFS Algorithm won: \n");

        if(wonSomething == 0)
        {
            appendToBuffer(winnerMsg, "No categories\n");
            printf("%s\n", winnerMsg);
            send_to_file(winnerMsg);
            return;
        }

        if(wonTurnAround == 1)
        {
            appendToBuffer(winnerMsg, "-Average Turn Around Time\n");
        }

        if(wonWaiting == 1)
        {
            appendToBuffer(winnerMsg, "-Average Waiting Time\n");
        }
        
        if(wonResponse == 1)
        {
            appendToBuffer(winnerMsg, "-Average Response Time\n");
        }

        printf("%s\n", winnerMsg);
        send_to_file(winnerMsg);
        return;
    }

    else if(choice == 2)
    {   
        appendToBuffer(winnerMsg, "SJF Algorithm won: \n");

        if(wonSomething == 0)
        {
            appendToBuffer(winnerMsg, "No categories\n");
            printf("%s\n", winnerMsg);
            return;
        }

        if(wonTurnAround == 1)
        {
            appendToBuffer(winnerMsg, "-Average Turn Around Time\n");
        }

        if(wonWaiting == 1)
        {
            appendToBuffer(winnerMsg, "-Average Waiting Time\n");
        }
        
        if(wonResponse == 1)
        {
            appendToBuffer(winnerMsg, "-Average Response Time\n");
        }

        printf("%s\n", winnerMsg);
        send_to_file(winnerMsg);
        return;
    }

    else if(choice == 3)
    {   
        appendToBuffer(winnerMsg, "SRTF Algorithm won: \n");

        if(wonSomething == 0)
        {
            appendToBuffer(winnerMsg, "No categories\n");
            printf("%s\n", winnerMsg);
            return;
        }

        if(wonTurnAround == 1)
        {
            appendToBuffer(winnerMsg, "-Average Turn Around Time\n");
        }

        if(wonWaiting == 1)
        {
            appendToBuffer(winnerMsg, "-Average Waiting Time\n");
        }
        
        if(wonResponse == 1)
        {
            appendToBuffer(winnerMsg, "-Average Response Time\n");
        }

        printf("%s\n", winnerMsg);
        send_to_file(winnerMsg);
        return;
    }

    else if(choice == 4)
    {   
        appendToBuffer(winnerMsg, "RR Algorithm won: \n");

        if(wonSomething == 0)
        {
            appendToBuffer(winnerMsg, "No categories\n");
            printf("%s\n", winnerMsg);
            return;
        }

        if(wonTurnAround == 1)
        {
            appendToBuffer(winnerMsg, "-Average Turn Around Time\n");
        }

        if(wonWaiting == 1)
        {
            appendToBuffer(winnerMsg, "-Average Waiting Time\n");
        }
        
        if(wonResponse == 1)
        {
            appendToBuffer(winnerMsg, "-Average Response Time\n");
        }

        printf("%s\n", winnerMsg);
        send_to_file(winnerMsg);
        return;
    }

    else if(choice == 5)
    {   
        appendToBuffer(winnerMsg, "Priority Algorithm won: \n");

        if(wonSomething == 0)
        {
            appendToBuffer(winnerMsg, "No categories\n");
            printf("%s\n", winnerMsg);
            return;
        }

        if(wonTurnAround == 1)
        {
            appendToBuffer(winnerMsg, "-Average Turn Around Time\n");
        }

        if(wonWaiting == 1)
        {
            appendToBuffer(winnerMsg, "-Average Waiting Time\n");
        }
        
        if(wonResponse == 1)
        {
            appendToBuffer(winnerMsg, "-Average Response Time\n");
        }

        printf("%s\n", winnerMsg);
        send_to_file(winnerMsg);
        return;
    }
}

int handleCheck(node *jobQueue[], int size, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[])
{
    linkerHead *readyQueue = (linkerHead *)malloc(sizeof(linkerHead));

    readyQueue->head = NULL;

    readyQueue->tail = NULL;

    linkerHead *executingProcess = (linkerHead *)malloc(sizeof(linkerHead));

    executingProcess->head = NULL;

    executingProcess->tail = NULL;

    int returnVal = runCheck(jobQueue, size, readyQueue, executingProcess, ganttOrder, ganttBlocks);

    free(readyQueue);
    free(executingProcess);

    if(returnVal == 0)
    {
        return 1;
    }

    return 0;
}

int runCheck(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[])
{
    node* readyArr[MAXJOBS] = {NULL}; //init to all NULL
    int elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
    int processesCompleted = 0;
    int totalTurnAroundTime = 0;
    int totalWaitingTime = 0;
    int totalResponseTime = 0;
    while(processesCompleted < MAXJOBS)
    {   
        placeArrivedJobs(jobQueue, readyArr, elapsedTime); //continuously places jobs into a readyArray
        sortForSRTF(readyArr, MAXJOBS); //sort the readyArray to be for FCFS
        placeJobs(readyArr, readyLinkedList, size); //the readyLinkedList->tail should be the front most node in the queue to be executed by the CPU

        executingProcess->head = readyLinkedList->tail; 
        
        node* selectedProcess = executingProcess->head; //the process to execute for this specific loop is the last item in the readyLinkedList

        while(selectedProcess->timeLeft == 0)
        {
            selectedProcess = selectedProcess->prevPtr; //get the node that hasn't been finished yet
        }
        
        node *thisProcess = selectedProcess;

        if (thisProcess->responseTime == 0 && thisProcess->respondedFlag == 0)
        {
            thisProcess->respondedFlag = 1;
            thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process
        }

        //retrieving process information to process it by the scheduler
        int burstTime = thisProcess -> burstTime;


        elapsedTime += TIMEUNIT;
        thisProcess->timeLeft -= TIMEUNIT; // the TIMEUNIT separates the loop out into slices of the ganntchart so that it can continuously check if it needs to be preempted out

        //setting the process's times to the formulas
        if (thisProcess->timeLeft == 0)
        {
            thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);
        
            thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

            //this writes out the process' turnAroundTime etc etc into the txt file
            //getNodeProperties(thisProcess);

            processesCompleted += 1;
        }

        insertIntoGanttOrder(thisProcess, ganttOrder, elapsedTime);

    }

    char schedulingType[] = "SRTF";

    getGanttBlocks(ganttOrder, ganttBlocks, schedulingType);

    int ganttBlocksSize = countGanttSize(ganttBlocks, ganttSize);

    ganttBlocksSize -= MAXJOBS; //if == 0, then it means nothing got preempted

    return ganttBlocksSize;
}

int handleCheckPriority(node *jobQueue[], int size, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[])
{
    linkerHead *readyQueue = (linkerHead *)malloc(sizeof(linkerHead));

    readyQueue->head = NULL;

    readyQueue->tail = NULL;

    linkerHead *executingProcess = (linkerHead *)malloc(sizeof(linkerHead));

    executingProcess->head = NULL;

    executingProcess->tail = NULL;

    int returnVal = runPriorityCheck(jobQueue, size, readyQueue, executingProcess, ganttOrder, ganttBlocks);

    free(readyQueue);
    free(executingProcess);

    if(returnVal == 0)
    {
        return 1;
    }

    return 0;
}

int runPriorityCheck(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess, ganttStruct* ganttOrder[], ganttStruct* ganttBlocks[])
{
    node* readyArr[MAXJOBS] = {NULL}; //init to all NULL
    int elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
    int processesCompleted = 0;
    int totalTurnAroundTime = 0;
    int totalWaitingTime = 0;
    int totalResponseTime = 0;

    while(processesCompleted < MAXJOBS)
    {   
        placeArrivedJobs(jobQueue, readyArr, elapsedTime); //continuously places jobs into a readyArray
        sortForPriority(readyArr, MAXJOBS); //sort the readyArray to be for FCFS
        placeJobs(readyArr, readyLinkedList, size); //the readyLinkedList->tail should be the front most node in the queue to be executed by the CPU

        executingProcess->head = readyLinkedList->tail; 
        
        node* selectedProcess = executingProcess->head; //the process to execute for this specific loop is the last item in the readyLinkedList

        while(selectedProcess->timeLeft == 0)
        {
            selectedProcess = selectedProcess->prevPtr; //get the node that hasn't been finished yet
        }
        
        node *thisProcess = selectedProcess;

        if (thisProcess->responseTime == 0 && thisProcess->respondedFlag == 0)
        {
            thisProcess->respondedFlag = 1;
            thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process
        }

        //retrieving process information to process it by the scheduler
        int burstTime = thisProcess -> burstTime;

        elapsedTime += TIMEUNIT;
        thisProcess->timeLeft -= TIMEUNIT; // the TIMEUNIT separates the loop out into slices of the ganntchart so that it can continuously check if it needs to be preempted out

        //setting the process's times to the formulas
        if (thisProcess->timeLeft == 0)
        {
            thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);

            thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

            //this writes out the process' turnAroundTime etc etc into the txt file
            //getNodeProperties(thisProcess);

            processesCompleted += 1;

        }

        //updating the total times to calculate the averages of later on
        insertIntoGanttOrder(thisProcess, ganttOrder, elapsedTime);
    }
    
    char schedulingType[] = "Priority";

    getGanttBlocks(ganttOrder, ganttBlocks, schedulingType);

    int ganttBlocksSize = countGanttSize(ganttBlocks, ganttSize);

    ganttBlocksSize -= MAXJOBS; //if == 0, then it means nothing got preempted

    return ganttBlocksSize;
}

void generateNoGaps(node* jobQueue[])
{
    int thereIsAGap = 1;
    while(thereIsAGap)
    {
        destroyJobQueue(jobQueue);
        for(int i = 0; i < MAXJOBS; i++)
        {
            jobQueue[i] = generateNode(i);
        }
        thereIsAGap = checkForGap(jobQueue, MAXJOBS);
    }

}

void generateNoGapsPriority(node* jobQueue[])
{
    int thereIsAGap = 1;
    while(thereIsAGap)
    {
        destroyJobQueue(jobQueue);
        for(int i = 0; i < MAXJOBS; i++)
        {
            jobQueue[i] = generateNode(i);
        }
        thereIsAGap = checkForGap(jobQueue, MAXJOBS);
    }

}

int isAscending(node* jobQueue[], int choice)
{
    if(choice == 1)
    {
        sortForFCFS(jobQueue, MAXJOBS);
    }
    else if(choice == 5)
    {
        sortForPriority(jobQueue, MAXJOBS);
    }

    for (int i = 0; i < MAXJOBS-1; i++)
    {
        if (jobQueue[i] == NULL)
        {
            return 0;
        }

        if (jobQueue[i]->burstTime <= jobQueue[i+1]->burstTime) // eg: 3units <= 4units
        {
            continue; 
        }

        return 0; //if any ahead are lower burst than the previous
    }

    return 1; //IFF everything is in ascending order
}