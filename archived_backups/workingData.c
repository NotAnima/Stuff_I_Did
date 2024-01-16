#include <stdio.h>
#include <time.h>
#include "workingData.h"

#define timeQuantum 2
#define BUFFER_SIZE 1024
#define MAXJOBS 6
#define sharedArrivals 3
#define sharedBursts 3
#define sharedPriorities 2

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
    localNode->pid = pidToAssign + 1;
    localNode->arrivalTime = arrivalTime;
    localNode->burstTime = burstTime;
    localNode->priority = priority;
    localNode->timeLeft = timeLeft;
    localNode->active = status;
    localNode->waitingTime = 0;
    localNode->turnAroundTime = 0;
    localNode->responseTime = 0;
    localNode->originalPriority = originalPriority;
    localNode->nextPtr = NULL;
    localNode->prevPtr = NULL;
    /*char *formattedString;
    sprintf(formattedString, "Node pid = %d ,value of arrivalTime = %d, burstTime = %d, priority = %d, timeLeft = %d, status = %d", localNode->pid, localNode->arrivalTime, localNode->burstTime, localNode->priority, localNode->timeLeft, localNode->active);
    send_to_file(formattedString);*/
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

int getListSize(linkerHead* head)
{
    int count = 0;
    node *currentPtr = head->head;

    if (head->head == NULL)
    {
        return 0;
    }

    while(currentPtr != NULL)
    {
        count++;
        currentPtr = currentPtr -> nextPtr;
    }
    return count;
}

node* getTailAddress(linkerHead* head)
{

    node *currentPtr = head->head;
    while(currentPtr -> nextPtr != NULL)
    {
        currentPtr = currentPtr -> nextPtr;
    }
    return currentPtr;
}

void removeAtTail(linkerHead* addressHead)
{
    if (addressHead->tail == NULL)
    {
        return; //linkedList is empty
    }

    node *ptrToFree = addressHead->tail;

    addressHead->tail = addressHead->tail->prevPtr; //give the tail of the linkedList tail to be the node before the last one
    
    free(ptrToFree);

    return;
}

void pointPreviousAtTail(linkerHead* addressHead)
{
    if (addressHead->tail == NULL)
    {
        return; //linkedList is empty
    }

    //node *ptrToFree = addressHead->tail;
   
    addressHead->tail = addressHead->tail->prevPtr; //give the tail of the linkedList tail to be the node before the last one
    
    return;
}

int removeNodeByAddress(linkerHead* addressOfLinkHead, node *addressToFree)
{
    //node *ptrToRemove = NULL;

    node *prevPtr = NULL;

    node *currentPtr = addressOfLinkHead->head;

    while (currentPtr->nextPtr != NULL)
    {
        if (currentPtr == addressToFree)
        {
            prevPtr->nextPtr = currentPtr->nextPtr;

            currentPtr->nextPtr->prevPtr = prevPtr;

            free(currentPtr);

            return 1; //successful free
        }
        prevPtr = currentPtr;

        currentPtr = currentPtr->nextPtr;
    }
    return 0; // no proper address given to free
}

int removeFinishedNodes(linkerHead* addressOfLinkHead)
{  
    node *prevPtr = NULL;

    node *currentPtr = addressOfLinkHead->head;

    while (currentPtr->nextPtr != NULL)
    {
        if (currentPtr->timeLeft == 0) //indicates that the process has finished and can be removed from the queue
        {
            if (currentPtr == addressOfLinkHead->head) //if the node to delete is at the back of the queue, address are just really huge integer values
            {
                addressOfLinkHead->head = currentPtr->nextPtr;
            }
            //if it is not the only node in the linkedList, do not adjust the head of the linkedList

            prevPtr->nextPtr = currentPtr->nextPtr; // 1 <-> 2 <-> 3

            currentPtr->nextPtr->prevPtr = prevPtr; //the next Node after the current ptr will be assigned it's prevPtr to be the prevPtr's node 1 <ignores current> 3 1 links to 3
            
            currentPtr->nextPtr = NULL; 

            currentPtr->prevPtr = NULL;

            free(currentPtr); //destroys the node and free's the malloc memory

            return 1; //successfully free'd
        }

        prevPtr = currentPtr;

        currentPtr = currentPtr->nextPtr;
    }

    return 0; //nothing was free'd because nothing was 0 time left

}

void printAtTail(linkerHead *head)
{
    //printf("Printing from the tail...\n");
    int arrivalTime = head->tail->arrivalTime;
    int burstTime = head->tail->burstTime;
    int priority = head->tail->priority;
    char formattedString[BUFFER_SIZE];
    sprintf(formattedString,"Arrival: %d, Burst: %d, Priority: %d", arrivalTime, burstTime, priority);
    //printf("%s\n",formattedString);
    //printf("The address of the tail node is: %p\n", head->tail);
    //printf("The address of the head is %p\n", head->head);
    //printf("The address of the head is: %p\n", &head);
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
void printNodesOrder(node* arr[], int size)
{
    for (int i = 0; i < size; i++)
    {   
        node *localNode = arr[i];
        if (localNode == NULL)
        {
            printf("\nIt was a NULL\n");
        }
        else
        {
            char formattedString[BUFFER_SIZE];
            sprintf(formattedString, "Node value of arrivalTime = %d, burstTime = %d, priority = %d, timeLeft = %d, status = %d, address = %p", localNode->arrivalTime, localNode->burstTime, localNode->priority, localNode->timeLeft, localNode->active, arr[i]);
            printf("%s\n",formattedString);
        }
    }
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
    mergeSortByBurst(jobQueue, size);
}
//copy paste the merge sort rules for the other types of scheduling and change the attribute to compare
//need to implement a reOrder function that adjusts the position of the 
int get_choice(){
  int choice;
  printf("Choose between choice 1 and 5:\n1) First Come First Serve Algorithm\n2) Shortest Job First Algorithm\n3) Shortest Remaining Time First Algorithm\n4) Round-Robin Algorithm\n5) Priority Algorithm\n\nPick Your Choice Here >> ");
  scanf("%d", &choice);
  if(choice > 5 || choice < 0)
  {
    printf("\nThat is invalid choice! Pick 1-5.\n");
  }
  printf("\nChoice is %d\n\n", choice);
  return choice;
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

    int arrivalTimeArr[9] = {0};

    int burstTimeArr[8] = {0};//must take burstTime and - 3

    int priorityArr[4] = {0}; //must take priority and -1

    for (int i = 0; i < MAXJOBS; i++) //populate all the arrays based off the jobQueue array of nodes
    {
        node *localNode = jobQueue[i]; //get the node
        arrivalTimeArr[localNode->arrivalTime]++;
        burstTimeArr[localNode->burstTime-3]++;
        priorityArr[localNode->priority-1]++;
    }

    for (int i = 0; i < 9; i++)
    {
        if (arrivalTimeArr[i] > sharedArrivals) //if there are 4 or more jobs that have the same arrivalTime, then return 0
        {return 0;}
    }
    
    for (int i = 0; i < 8; i++)
    {
        if (burstTimeArr[i] > sharedBursts) //if there are 3 or more jobs that have the same burstTime, then return 0
        {return 0;}
    }

    for (int i = 0; i < 4; i++)
    {
        if (priorityArr[i] > sharedPriorities) //if there are 4 or more jobs that have the same priority, then return 0
        {return 0;}
    }
    if (checkForGap(jobQueue, MAXJOBS))
    {
        return 0;
    }
    //printArray(arrivalTimeArr);
    //printArray(burstTimeArr);
    //printArray(priorityArr);

    //^ only for debugging purposes

    return 1; //1 IFF all the nodes are valid
}

void printArray(int *arr)
{
    for (int i = 0; i < MAXJOBS; i++)
    {
        printf("%d\n", arr[i]);
    }
    printf("\n");
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
            //change ^ this logic, if readyArray already has a job in it, it will replace it
        }
        /*else
        {
            readyArray[i] = NULL; //puts NULL to fill the array up
        }*/
        //this cost me 2 hours lmao
    }
}

void removeDoneJobs(node* readyArray[])
{
    for (int i = 0; i < MAXJOBS; i++)
    {
        if (readyArray[i] == NULL)
        {
            continue;
        }
        else if(readyArray[i]->active == 1 && readyArray[i]->timeLeft == 0) //if the process was active and doesn't have any timeLeft
        {
            readyArray[i] = NULL;
        }
        else
        {
            continue;
        }
    }
    return;
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

void resetProcesses(node* jobQueue[], int size)
{
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
        jobQueue[i]->timeSlice = 0;
        jobQueue[i]->turnAroundTime = 0;
        jobQueue[i]->waitingTime = 0;
        jobQueue[i]->responseTime = 0;
        jobQueue[i]->nextPtr = NULL;
        jobQueue[i]->prevPtr = NULL;
    }
    //printf("Successfully restored the processes to their original generation.\n");
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
    //printf("\nLowestArrivalTime is %d\n", lowestArrivalTime);
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

void writeOutAverageTimes(char *schedulingType, int totalTurnAroundTime, float totalWaitingTime, float totalResponseTime)
{
    char formattedString[BUFFER_SIZE];

    float averageTurnAroundTime = ((float)totalTurnAroundTime) / MAXJOBS;

    float averageWaitingTime = ((float)totalWaitingTime) / MAXJOBS;

    float averageResponseTime = ((float)totalResponseTime) / MAXJOBS;

    sprintf(formattedString, "\nFOR %s ALGORITHM:\nAverage Turn Around Time: %.2f, Average Waiting Time: %.2f, Average Response Time: %.2f\n", schedulingType, averageTurnAroundTime, averageWaitingTime, averageResponseTime);

    send_to_file(formattedString);
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
            //printf("\nThis next process arrived with a gap after\n");
            return 1; //there is a gap in the process
        }
        int burstTime = currentProcess->timeLeft;
        elapsedTime += burstTime;
        //printf("\nNo gap\n");
    }

    return 0;
}

void generateSolidNodes(node* jobQueue[])
{
    node* node1 = (node*)malloc(sizeof(node));
    node1->pid = 1; node1->arrivalTime = 0; node1->burstTime = 3; node1->priority = 1; node1->timeLeft = 3; node1->waitingTime = 0; node1->turnAroundTime = 0;
    node1 ->responseTime = 0; node1 -> active = 0; node1->nextPtr = NULL; node1->prevPtr = NULL;

    node* node2 = (node*)malloc(sizeof(node));
    node2->pid = 2; node2->arrivalTime = 1; node2->burstTime = 5; node2->priority = 1; node2->timeLeft = 5; node2->waitingTime = 0; node2->turnAroundTime = 0;
    node2 ->responseTime = 0; node2 -> active = 0; node2->nextPtr = NULL; node2->prevPtr = NULL;

    node* node3 = (node*)malloc(sizeof(node));
    node3->pid = 3; node3->arrivalTime = 0; node3->burstTime = 10; node3->priority = 2; node3->timeLeft = 10; node3->waitingTime = 0; node3->turnAroundTime = 0;
    node3 ->responseTime = 0; node3 -> active = 0; node3->nextPtr = NULL; node3->prevPtr = NULL;
    
    node* node4 = (node*)malloc(sizeof(node));
    node1->pid = 4; node1->arrivalTime = 4; node1->burstTime = 5; node1->priority = 4; node1->timeLeft = 5; node1->waitingTime = 0; node1->turnAroundTime = 0;
    node1 ->responseTime = 0; node1 -> active = 0; node1->nextPtr = NULL; node1->prevPtr = NULL;

    node* node5 = (node*)malloc(sizeof(node));
    node1->pid = 5; node1->arrivalTime = 7; node1->burstTime = 4; node1->priority = 3; node1->timeLeft = 4; node1->waitingTime = 0; node1->turnAroundTime = 0;
    node1 ->responseTime = 0; node1 -> active = 0; node1->nextPtr = NULL; node1->prevPtr = NULL;

    node* node6 = (node*)malloc(sizeof(node));
    node1->pid = 6; node1->arrivalTime = 3; node1->burstTime = 9; node1->priority = 4; node1->timeLeft = 9; node1->waitingTime = 0; node1->turnAroundTime = 0;
    node1 ->responseTime = 0; node1 -> active = 0; node1->nextPtr = NULL; node1->prevPtr = NULL;

    jobQueue[0] = node1;
    jobQueue[1] = node2;
    jobQueue[2]= node3;
    jobQueue[3]= node4;
    jobQueue[4]= node5;
    jobQueue[5]= node6;
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